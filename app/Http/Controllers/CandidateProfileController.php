<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateProfileStepRequest;
use App\Models\CandidateEducation;
use App\Models\CandidateDocument;
use App\Models\CandidateProfile;
use App\Models\CandidateWorkExperience;
use App\Services\CandidateDocumentService;
use App\Services\CandidateEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CandidateProfileController extends Controller
{
    public function show(Request $request, ?int $step = null): View|RedirectResponse
    {
        abort_if($step !== null && ($step < 1 || $step > 4), 404);

        $user = $request->user();
        $profile = $user->candidateProfile()->with(['educations.document', 'workExperiences.document'])->first();

        if ($step !== null && ! $profile?->profile_completed_at && $step > ($profile?->current_step ?? 1)) {
            return redirect()->route($profile ? 'career.profile.step' : 'career.profile', $profile ? ['step' => $profile->current_step] : []);
        }

        $activeStep = $step ?? ($profile?->profile_completed_at ? null : ($profile?->current_step ?? 1));

        return view('career.profile.show', [
            'profile' => $profile,
            'activeStep' => $activeStep,
            'isSummary' => $activeStep === null,
            'activeTab' => $request->string('tab')->value() === 'history' ? 'history' : 'profile',
            'photo' => $user->activeDocument('photo'),
            'cv' => $user->activeDocument('cv'),
            'applications' => $user->applications()
                ->with(['job', 'department', 'position', 'location'])
                ->latest('submitted_at')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function store(
        StoreCandidateProfileStepRequest $request,
        int $step,
        CandidateDocumentService $documents,
        CandidateEligibilityService $eligibility,
    ): RedirectResponse {
        abort_if($step < 1 || $step > 4, 404);

        $user = $request->user();
        $profile = $user->candidateProfile()->firstOrCreate([], [
            'full_name' => $user->display_name,
            'current_step' => 1,
        ]);

        if (! $profile->profile_completed_at && $step > $profile->current_step) {
            return redirect()->route('career.profile.step', ['step' => $profile->current_step])
                ->with('warning', 'Selesaikan langkah sebelumnya terlebih dahulu.');
        }

        match ($step) {
            1 => $this->storeIdentity($request, $profile, $documents),
            2 => $this->storeDetails($request, $profile),
            3 => $this->storeEducation($request, $profile, $documents),
            4 => $this->storeExperience($request, $profile, $documents),
        };

        $profile->refresh();
        $profile->update(['current_step' => min(4, max($profile->current_step, $step + 1))]);

        if ($step === 4) {
            $missing = $eligibility->missingRequirements($user->fresh());
            if ($missing !== []) {
                throw ValidationException::withMessages([
                    'profile' => 'Profil belum lengkap: '.implode(', ', $missing).'.',
                ]);
            }

            $profile->update(['profile_completed_at' => now(), 'current_step' => 4]);
            $intended = $request->session()->pull('career.intended');

            return redirect($intended ?: route('career.profile'))
                ->with('success', 'Profil kandidat berhasil dilengkapi. Anda sekarang dapat mengirim lamaran.');
        }

        return redirect()->route('career.profile.step', ['step' => $step + 1])
            ->with('success', 'Data langkah '.$step.' berhasil disimpan.');
    }

    private function storeIdentity(StoreCandidateProfileStepRequest $request, CandidateProfile $profile, CandidateDocumentService $documents): void
    {
        foreach (['photo', 'cv'] as $type) {
            if (! $request->hasFile($type) && ! $request->user()->activeDocument($type)) {
                throw ValidationException::withMessages([$type => ucfirst($type).' wajib diunggah.']);
            }
        }

        $profile->update($request->safe()->only([
            'full_name', 'national_id', 'birth_date', 'birth_place', 'gender',
            'marital_status', 'blood_type', 'religion',
        ]));

        foreach (['photo', 'cv'] as $type) {
            if ($request->hasFile($type)) {
                $documents->store($request->user(), $request->file($type), $type);
            }
        }

        $request->user()->update(['name' => $request->string('full_name')->value()]);
    }

    private function storeDetails(StoreCandidateProfileStepRequest $request, CandidateProfile $profile): void
    {
        $details = $request->safe()->only([
            'height_cm', 'weight_kg', 'nationality', 'residence_city',
            'identity_address', 'phone', 'domicile_address',
        ]);
        $details['phone'] = $this->normalizePhone($details['phone']);
        $profile->update($details);
    }

    private function storeEducation(StoreCandidateProfileStepRequest $request, CandidateProfile $profile, CandidateDocumentService $documents): void
    {
        DB::transaction(function () use ($request, $profile, $documents): void {
            $existingHighSchool = $profile->educations()->where('level', 'high_school')->first();
            $highSchoolDocument = $existingHighSchool?->document;

            if ($request->hasFile('high_school.diploma')) {
                $highSchoolDocument = $documents->store($request->user(), $request->file('high_school.diploma'), 'high_school_diploma');
            }

            if (! $highSchoolDocument) {
                throw ValidationException::withMessages(['high_school.diploma' => 'Ijazah SMA/SMK wajib diunggah.']);
            }

            $high = $request->validated('high_school');
            $profile->educations()->updateOrCreate(
                ['level' => 'high_school'],
                [
                    'document_id' => $highSchoolDocument->id,
                    'institution_name' => $high['institution_name'],
                    'field_of_study' => $high['field_of_study'],
                    'start_year' => $high['start_year'],
                    'end_year' => $high['end_year'],
                    'final_score' => $high['final_score'],
                    'sort_order' => 0,
                ],
            );

            $keptIds = [];
            foreach ($request->validated('college_educations', []) as $index => $college) {
                $education = isset($college['id'])
                    ? $profile->educations()->where('level', 'college')->find($college['id'])
                    : null;
                $education ??= new CandidateEducation(['candidate_profile_id' => $profile->id, 'level' => 'college']);

                if ($request->hasFile("college_educations.{$index}.diploma")) {
                    if ($education->document_id) {
                        CandidateDocument::whereKey($education->document_id)->where('user_id', $request->user()->id)->update(['is_active' => false]);
                    }
                    $education->document_id = $documents->store(
                        $request->user(),
                        $request->file("college_educations.{$index}.diploma"),
                        'college_diploma',
                    )->id;
                }

                $education->fill([
                    'institution_name' => $college['institution_name'],
                    'field_of_study' => $college['degree'].' — '.$college['field_of_study'],
                    'start_year' => $college['start_year'],
                    'end_year' => $college['end_year'] ?? null,
                    'final_score' => $college['final_score'] ?? null,
                    'is_current' => empty($college['end_year']),
                    'sort_order' => $index + 1,
                ])->save();
                $keptIds[] = $education->id;
            }

            $removedEducationQuery = $profile->educations()->where('level', 'college')->when(
                $keptIds !== [],
                fn ($query) => $query->whereNotIn('id', $keptIds),
            );
            CandidateDocument::whereIn('id', (clone $removedEducationQuery)->pluck('document_id')->filter())
                ->where('user_id', $request->user()->id)
                ->update(['is_active' => false]);
            $removedEducationQuery->delete();
        });
    }

    private function storeExperience(StoreCandidateProfileStepRequest $request, CandidateProfile $profile, CandidateDocumentService $documents): void
    {
        DB::transaction(function () use ($request, $profile, $documents): void {
            $status = $request->string('experience_status')->value();
            $profile->update(['experience_status' => $status]);

            if ($status === 'fresh_graduate') {
                CandidateDocument::whereIn('id', $profile->workExperiences()->pluck('document_id')->filter())
                    ->where('user_id', $request->user()->id)
                    ->update(['is_active' => false]);
                $profile->workExperiences()->delete();
                return;
            }

            $keptIds = [];
            foreach ($request->validated('work_experiences', []) as $index => $work) {
                $experience = isset($work['id'])
                    ? $profile->workExperiences()->find($work['id'])
                    : null;
                $experience ??= new CandidateWorkExperience(['candidate_profile_id' => $profile->id]);

                if ($request->hasFile("work_experiences.{$index}.employment_letter")) {
                    if ($experience->document_id) {
                        CandidateDocument::whereKey($experience->document_id)->where('user_id', $request->user()->id)->update(['is_active' => false]);
                    }
                    $experience->document_id = $documents->store(
                        $request->user(),
                        $request->file("work_experiences.{$index}.employment_letter"),
                        'employment_letter',
                    )->id;
                }

                $isCurrent = (bool) ($work['is_current'] ?? false);
                $experience->fill([
                    'company_name' => $work['company_name'],
                    'initial_position' => $work['initial_position'],
                    'initial_started_at' => $work['initial_started_at'].'-01',
                    'initial_ended_at' => $work['initial_ended_at'].'-01',
                    'initial_responsibilities' => $work['initial_responsibilities'],
                    'final_position' => $work['final_position'],
                    'final_started_at' => $work['final_started_at'].'-01',
                    'final_ended_at' => $isCurrent || empty($work['final_ended_at']) ? null : $work['final_ended_at'].'-01',
                    'final_responsibilities' => $work['final_responsibilities'],
                    'is_current' => $isCurrent,
                    'resign_year' => $isCurrent ? null : ($work['resign_year'] ?? null),
                    'last_salary' => $work['last_salary'] ?? null,
                    'resign_reason' => $isCurrent ? null : ($work['resign_reason'] ?? null),
                    'expected_salary' => $work['expected_salary'] ?? null,
                    'company_phone' => $this->normalizePhone($work['company_phone'] ?? null),
                    'supervisor_name' => $work['supervisor_name'] ?? null,
                    'supervisor_phone' => $this->normalizePhone($work['supervisor_phone'] ?? null),
                    'sort_order' => $index,
                ])->save();
                $keptIds[] = $experience->id;
            }

            $removedWorkQuery = $profile->workExperiences()->when(
                $keptIds !== [],
                fn ($query) => $query->whereNotIn('id', $keptIds),
            );
            CandidateDocument::whereIn('id', (clone $removedWorkQuery)->pluck('document_id')->filter())
                ->where('user_id', $request->user()->id)
                ->update(['is_active' => false]);
            $removedWorkQuery->delete();
        });
    }

    private function normalizePhone(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        $phone = trim($phone);
        $prefix = str_starts_with($phone, '+') ? '+' : '';

        return $prefix.preg_replace('/\D+/', '', $phone);
    }
}

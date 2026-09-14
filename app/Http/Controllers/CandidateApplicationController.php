<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTalentPoolApplicationRequest;
use App\Models\Job;
use App\Services\CandidateApplicationService;
use App\Services\CandidateEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CandidateApplicationController extends Controller
{
    public function storeJob(
        Request $request,
        string $slug,
        CandidateEligibilityService $eligibility,
        CandidateApplicationService $applications,
    ): RedirectResponse {
        $job = Job::query()->publiclyVisible()->with(['department', 'position', 'location'])->where('slug', $slug)->firstOrFail();

        if (! $eligibility->isComplete($request->user())) {
            $request->session()->put('career.intended', route('career.apply', ['slug' => $slug]));

            return redirect()->route('career.profile')->with('warning', 'Lengkapi profil sebelum mengirim lamaran.');
        }

        $application = $applications->submitForJob($request->user(), $job);

        return redirect()->route('career.profile', ['tab' => 'history'])->with(
            $application->wasRecentlyCreated ? 'success' : 'warning',
            $application->wasRecentlyCreated
                ? 'Lamaran berhasil dikirim dan berstatus Menunggu.'
                : 'Anda sudah pernah melamar posisi ini.',
        );
    }

    public function storeTalentPool(
        StoreTalentPoolApplicationRequest $request,
        CandidateEligibilityService $eligibility,
        CandidateApplicationService $applications,
    ): RedirectResponse {
        if (! $eligibility->isComplete($request->user())) {
            return redirect()->route('career.profile')->with('warning', 'Lengkapi profil sebelum mengirim CV.');
        }

        $application = $applications->submitTalentPool(
            $request->user(),
            $request->integer('department_id'),
            $request->integer('position_id'),
            $request->integer('location_id'),
        );

        return redirect()->route('career.profile', ['tab' => 'history'])->with(
            $application->wasRecentlyCreated ? 'success' : 'warning',
            $application->wasRecentlyCreated
                ? 'CV berhasil dikirim ke talent pool dan berstatus Menunggu.'
                : 'CV untuk pilihan tersebut sudah pernah dikirim.',
        );
    }
}

<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CandidateApplicationService
{
    public function submitForJob(User $user, Job $job): Application
    {
        return $this->submit($user, [
            'job_id' => $job->id,
            'department_id' => $job->department_id,
            'position_id' => $job->position_id,
            'location_id' => $job->location_id,
            'type' => 'job_application',
            'deduplication_key' => hash('sha256', "job:{$user->id}:{$job->id}"),
            'job_snapshot' => [
                'title' => $job->title,
                'slug' => $job->slug,
                'department' => $job->department->name,
                'position' => $job->position->name,
                'location' => $job->location->name,
            ],
        ]);
    }

    public function submitTalentPool(User $user, int $departmentId, int $positionId, int $locationId): Application
    {
        return $this->submit($user, [
            'department_id' => $departmentId,
            'position_id' => $positionId,
            'location_id' => $locationId,
            'type' => 'talent_pool',
            'deduplication_key' => hash('sha256', "talent:{$user->id}:{$departmentId}:{$positionId}:{$locationId}"),
        ]);
    }

    private function submit(User $user, array $attributes): Application
    {
        return DB::transaction(function () use ($user, $attributes): Application {
            $profile = $user->candidateProfile()->with(['educations', 'workExperiences'])->firstOrFail();
            $documentIds = collect([
                $user->activeDocument('photo')?->id,
                $user->activeDocument('cv')?->id,
            ])->merge($profile->educations->pluck('document_id'))
                ->merge($profile->workExperiences->pluck('document_id'))
                ->filter()
                ->unique();
            $documents = $user->candidateDocuments()->whereIn('id', $documentIds)->get();

            return Application::firstOrCreate(
                ['deduplication_key' => $attributes['deduplication_key']],
                [
                    ...$attributes,
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'candidate_snapshot' => [
                        'name' => $profile->full_name,
                        'email' => $user->email,
                        'phone' => $profile->phone,
                        'residence_city' => $profile->residence_city,
                        'experience_status' => $profile->experience_status,
                        'education' => $profile->educations->map->only([
                            'level', 'institution_name', 'field_of_study', 'start_year', 'end_year', 'final_score',
                        ])->all(),
                        'work_experience' => $profile->workExperiences->map->only([
                            'company_name', 'initial_position', 'initial_started_at', 'initial_ended_at',
                            'final_position', 'final_started_at', 'final_ended_at', 'is_current',
                        ])->all(),
                    ],
                    'document_snapshot' => $documents->map->only([
                        'id', 'type', 'original_name', 'mime_type', 'size_bytes', 'checksum',
                    ])->values()->all(),
                    'submitted_at' => now(),
                ],
            );
        });
    }
}

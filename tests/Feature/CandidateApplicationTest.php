<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\CandidateDocument;
use App\Models\CandidateEducation;
use App\Models\CandidateProfile;
use App\Models\Job;
use App\Models\User;
use Database\Seeders\CareerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CareerSeeder::class);
    }

    public function test_complete_candidate_can_apply_only_once_and_see_history(): void
    {
        $user = $this->completeCandidate();
        $job = Job::where('slug', 'kepala-depo')->firstOrFail();

        $this->actingAs($user)
            ->get(route('career.apply', ['slug' => $job->slug]))
            ->assertOk()
            ->assertSee('Profil siap dikirim')
            ->assertSee('Lamar Sekarang');

        $this->actingAs($user)
            ->post(route('career.applications.job', ['slug' => $job->slug]))
            ->assertRedirect(route('career.profile', ['tab' => 'history']))
            ->assertSessionHas('success');

        $this->actingAs($user)
            ->post(route('career.applications.job', ['slug' => $job->slug]))
            ->assertSessionHas('warning');

        $this->assertSame(1, Application::count());

        $this->actingAs($user)
            ->get(route('career.profile', ['tab' => 'history']))
            ->assertOk()
            ->assertSee('Kepala Depo')
            ->assertSee('Menunggu');
    }

    public function test_talent_pool_rejects_a_position_from_another_department(): void
    {
        $user = $this->completeCandidate();
        $job = Job::where('slug', 'kepala-depo')->firstOrFail();
        $other = Job::where('slug', 'sales-supervisor')->firstOrFail();

        $this->actingAs($user)
            ->from(route('career.send-cv'))
            ->post(route('career.applications.talent-pool'), [
                'department_id' => $job->department_id,
                'position_id' => $other->position_id,
                'location_id' => $job->location_id,
            ])
            ->assertRedirect(route('career.send-cv'))
            ->assertSessionHasErrors('position_id');
    }

    private function completeCandidate(): User
    {
        $user = User::create(['name' => 'Rina Kandidat', 'email' => 'rina@example.com', 'password' => 'rahasia123']);
        $profile = CandidateProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Rina Kandidat',
            'national_id' => '3174010101010001',
            'birth_date' => '1998-01-01',
            'birth_place' => 'Jakarta',
            'gender' => 'female',
            'marital_status' => 'single',
            'blood_type' => 'O',
            'religion' => 'islam',
            'height_cm' => 165,
            'weight_kg' => 55,
            'nationality' => 'Indonesia',
            'residence_city' => 'Jakarta',
            'identity_address' => 'Jakarta Selatan',
            'domicile_address' => 'Jakarta Selatan',
            'phone' => '081234567890',
            'experience_status' => 'fresh_graduate',
            'current_step' => 4,
            'profile_completed_at' => now(),
        ]);

        $photo = $this->document($user, 'photo', 'foto.jpg', 'image/jpeg');
        $cv = $this->document($user, 'cv', 'cv.pdf', 'application/pdf');
        $diploma = $this->document($user, 'high_school_diploma', 'ijazah.pdf', 'application/pdf');

        CandidateEducation::create([
            'candidate_profile_id' => $profile->id,
            'document_id' => $diploma->id,
            'level' => 'high_school',
            'institution_name' => 'SMAN 1 Jakarta',
            'field_of_study' => 'IPA',
            'start_year' => 2013,
            'end_year' => 2016,
            'final_score' => 85,
        ]);

        return $user;
    }

    private function document(User $user, string $type, string $name, string $mime): CandidateDocument
    {
        return CandidateDocument::create([
            'user_id' => $user->id,
            'type' => $type,
            'disk' => 'local',
            'path' => "candidates/{$user->id}/{$type}/{$name}",
            'original_name' => $name,
            'mime_type' => $mime,
            'size_bytes' => 100,
            'checksum' => hash('sha256', $name),
            'scan_status' => 'pending_scan',
            'is_active' => true,
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\CandidateDocument;
use App\Models\CandidateEducation;
use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidateProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_candidate_profile(): void
    {
        $this->get(route('career.profile'))->assertRedirect(route('login'));
    }

    public function test_candidate_can_save_identity_and_private_documents(): void
    {
        Storage::fake('local');
        $user = $this->user();

        $this->actingAs($user)->put(route('career.profile.store', ['step' => 1]), [
            'photo' => UploadedFile::fake()->create('foto.jpg', 100, 'image/jpeg'),
            'cv' => UploadedFile::fake()->create('cv.pdf', 200, 'application/pdf'),
            'full_name' => 'Rina Kandidat',
            'national_id' => '3174010101010001',
            'birth_date' => '1998-01-01',
            'birth_place' => 'Jakarta',
            'gender' => 'female',
            'marital_status' => 'single',
            'blood_type' => 'O',
            'religion' => 'islam',
        ])->assertRedirect(route('career.profile.step', ['step' => 2]));

        $profile = CandidateProfile::firstOrFail();
        $this->assertSame('3174010101010001', $profile->national_id);
        $this->assertNotSame('3174010101010001', $profile->getRawOriginal('national_id'));
        $this->assertCount(2, $user->candidateDocuments()->get());

        foreach ($user->candidateDocuments as $document) {
            Storage::disk('local')->assertExists($document->path);
        }
    }

    public function test_candidate_cannot_download_another_candidates_document(): void
    {
        Storage::fake('local');
        $owner = $this->user('owner@example.com');
        $viewer = $this->user('viewer@example.com');
        Storage::disk('local')->put('candidates/1/cv/file.pdf', 'private');
        $document = CandidateDocument::create([
            'user_id' => $owner->id,
            'type' => 'cv',
            'disk' => 'local',
            'path' => 'candidates/1/cv/file.pdf',
            'original_name' => 'cv.pdf',
            'mime_type' => 'application/pdf',
            'size_bytes' => 7,
            'checksum' => hash('sha256', 'private'),
            'scan_status' => 'pending_scan',
            'is_active' => true,
        ]);

        $this->actingAs($viewer)
            ->get(route('career.documents.show', $document))
            ->assertForbidden();
    }

    private function user(string $email = 'rina@example.com'): User
    {
        return User::create(['name' => 'Rina Kandidat', 'email' => $email, 'password' => 'rahasia123']);
    }
}

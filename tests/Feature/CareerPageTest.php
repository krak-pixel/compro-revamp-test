<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Database\Seeders\CareerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CareerPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CareerSeeder::class);
    }

    public function test_public_career_page_lists_six_of_twelve_active_jobs(): void
    {
        $this->get(route('career.index'))
            ->assertOk()
            ->assertViewHas('jobs', fn ($jobs) => $jobs->count() === 6 && $jobs->total() === 12)
            ->assertSee('Bergabunglah dengan')
            ->assertSee('Menampilkan <strong class="font-semibold text-tvip-heading">12</strong> lowongan', false)
            ->assertSee('Halaman 1 / 2')
            ->assertSee('Preseller GT-Retail AFH')
            ->assertSee('Driver Distribusi');
    }

    public function test_search_and_department_filter_are_restorable_from_the_url(): void
    {
        $this->get(route('career.index', [
            'q' => 'target',
            'department' => 'sales',
        ]))
            ->assertOk()
            ->assertSee('value="target"', false)
            ->assertSee('value="sales" selected', false)
            ->assertSee('Preseller GT-Retail AFH')
            ->assertDontSee('Admin Depo');
    }

    public function test_job_detail_has_a_shareable_url_and_opens_the_drawer(): void
    {
        $this->get(route('career.show', ['slug' => 'kepala-depo']))
            ->assertOk()
            ->assertSee('Job Detail')
            ->assertSee('Kepala Depo')
            ->assertSee('Deskripsi Pekerjaan')
            ->assertSee('Kualifikasi');
    }

    public function test_guest_is_redirected_to_login_before_apply_or_send_cv(): void
    {
        $this->get(route('career.apply', ['slug' => 'kepala-depo']))
            ->assertRedirect(route('login'));

        $this->get(route('career.send-cv'))
            ->assertRedirect(route('login'));
    }

    public function test_incomplete_candidate_is_redirected_to_the_v3_profile_before_applying(): void
    {
        $user = User::create([
            'name' => 'Rina Kandidat',
            'email' => 'rina@example.com',
            'password' => 'rahasia123',
        ]);

        $this->actingAs($user)
            ->get(route('career.apply', ['slug' => 'kepala-depo']))
            ->assertRedirect(route('career.profile'))
            ->assertSessionHas('warning');
    }

    public function test_expired_job_is_not_publicly_listed_or_accessible(): void
    {
        $job = Job::where('slug', 'kepala-depo')->firstOrFail();
        $job->update(['closes_at' => today()->subDay()]);

        $this->get(route('career.index'))
            ->assertOk()
            ->assertDontSee('/karir/kepala-depo"', false);

        $this->get(route('career.show', ['slug' => 'kepala-depo']))
            ->assertNotFound();
    }

    public function test_sitemap_contains_only_active_job_urls(): void
    {
        Job::where('slug', 'kepala-depo')->firstOrFail()->update([
            'closes_at' => today()->subDay(),
        ]);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('career.index'))
            ->assertSee(route('career.show', ['slug' => 'sales-supervisor']))
            ->assertDontSee(route('career.show', ['slug' => 'kepala-depo']));
    }
}

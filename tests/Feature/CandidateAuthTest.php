<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_register_and_is_asked_to_login_manually(): void
    {
        $response = $this->post(route('career.register.store'), [
            'name' => 'Budi Kandidat',
            'email' => 'budi@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'name' => 'Budi Kandidat',
            'email' => 'budi@example.com',
        ]);
    }

    public function test_candidate_login_restores_the_intended_career_action(): void
    {
        $user = User::create([
            'name' => 'Sari Kandidat',
            'email' => 'sari@example.com',
            'password' => 'rahasia123',
        ]);

        $response = $this
            ->withSession(['url.intended' => '/karir/kepala-depo/apply'])
            ->post(route('career.login.store'), [
                'email' => 'sari@example.com',
                'password' => 'rahasia123',
            ]);

        $response->assertRedirect('/karir/kepala-depo/apply');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_are_reported_without_clearing_email(): void
    {
        $response = $this
            ->from(route('login'))
            ->post(route('career.login.store'), [
                'email' => 'salah@example.com',
                'password' => 'password-yang-salah',
            ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email')
            ->assertSessionHasInput('email', 'salah@example.com');

        $this->assertGuest();
    }

    public function test_candidate_can_logout(): void
    {
        $user = User::create([
            'name' => 'Dewi Kandidat',
            'email' => 'dewi@example.com',
            'password' => 'rahasia123',
        ]);

        $this->actingAs($user)
            ->post(route('career.logout'))
            ->assertRedirect(route('career.index'));

        $this->assertGuest();
    }
}

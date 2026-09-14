<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_message_is_saved_and_notification_is_sent(): void
    {
        Mail::fake();

        $response = $this->post('/kontak', [
            'name' => 'Budi Santoso',
            'company' => 'PT Mitra Distribusi',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Permintaan kerja sama distribusi',
            'message' => 'Kami ingin berdiskusi mengenai kebutuhan distribusi perusahaan.',
            'website' => '',
        ]);

        $response->assertRedirect('/#kontak-kami');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'budi@example.com',
            'status' => 'new',
        ]);

        Mail::assertSent(ContactMessageReceived::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactMessageController extends Controller
{
    public function __invoke(StoreContactMessageRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except('website');

        $contactMessage = ContactMessage::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 1000),
            'status' => 'new',
        ]);

        $adminEmail = config('mail.contact_admin');

        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new ContactMessageReceived($contactMessage));
            } catch (Throwable $exception) {
                Log::warning('Pesan kontak tersimpan, tetapi email notifikasi gagal dikirim.', [
                    'contact_message_id' => $contactMessage->id,
                    'exception' => $exception->getMessage(),
                ]);
            }
        }

        return redirect('/#kontak-kami')->with(
            'contact_success',
            'Pesan Anda sudah diterima. Tim TVIP akan segera menghubungi Anda.'
        );
    }
}

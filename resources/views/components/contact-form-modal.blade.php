<div
    x-cloak
    x-show="contactModalOpen"
    x-transition.opacity
    class="fixed inset-0 z-[60] flex items-center justify-center bg-tvip-heading/60 p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="contact-form-title"
    @keydown.escape.window="closeContactForm()"
>
    <div class="absolute inset-0" @click="closeContactForm()" aria-hidden="true"></div>

    <x-card variant="cta" class="relative z-10 max-h-[calc(100vh-48px)] w-full max-w-3xl overflow-y-auto p-6 md:p-8" @click.stop>
        <div class="flex items-start justify-between gap-6">
            <div>
                <h2 id="contact-form-title" class="text-[30px] font-bold leading-9 text-tvip-heading">Kirim Pesan kepada TVIP</h2>
                <p class="mt-2 text-base leading-[26px] text-tvip-body">Isi formulir berikut. Tim TVIP akan menghubungi Anda melalui email atau telepon.</p>
            </div>
            <button type="button" class="flex size-10 shrink-0 items-center justify-center rounded-tvip-full bg-tvip-social-bg text-2xl leading-none text-tvip-heading" @click="closeContactForm()" aria-label="Tutup formulir">×</button>
        </div>

        <form method="POST" action="{{ route('contact.store') }}" class="mt-8 grid gap-6 md:grid-cols-2">
            @csrf

            <div class="hidden" aria-hidden="true">
                <label for="website">Website</label>
                <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
            </div>

            <div>
                <label for="name" class="tvip-field-label">Nama *</label>
                <input x-ref="contactName" id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="100" autocomplete="name" class="tvip-field">
                @error('name')<p class="tvip-field-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="company" class="tvip-field-label">Perusahaan</label>
                <input id="company" name="company" type="text" value="{{ old('company') }}" maxlength="150" autocomplete="organization" class="tvip-field">
                @error('company')<p class="tvip-field-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="tvip-field-label">Email *</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" class="tvip-field">
                @error('email')<p class="tvip-field-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="tvip-field-label">Nomor Telepon</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" maxlength="30" autocomplete="tel" class="tvip-field">
                @error('phone')<p class="tvip-field-error">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="subject" class="tvip-field-label">Subjek *</label>
                <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required maxlength="150" class="tvip-field">
                @error('subject')<p class="tvip-field-error">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="message" class="tvip-field-label">Pesan *</label>
                <textarea id="message" name="message" rows="6" required minlength="10" maxlength="5000" class="tvip-field resize-y">{{ old('message') }}</textarea>
                @error('message')<p class="tvip-field-error">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-wrap justify-end gap-4 md:col-span-2">
                <x-button type="button" variant="outline" size="cta" @click="closeContactForm()">Batal</x-button>
                <x-button type="submit" size="cta">Kirim Pesan</x-button>
            </div>
        </form>
    </x-card>
</div>

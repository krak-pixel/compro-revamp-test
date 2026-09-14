<div class="mt-8 flex flex-col-reverse gap-3 border-t border-tvip-divider pt-6 sm:flex-row sm:justify-between">
    @if ($step > 1)
        <a href="{{ route('career.profile.step', ['step' => $step - 1]) }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button border border-tvip-divider px-6 text-sm font-semibold text-tvip-heading hover:bg-tvip-surface">Kembali</a>
    @else
        <a href="{{ route('career.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button border border-tvip-divider px-6 text-sm font-semibold text-tvip-heading hover:bg-tvip-surface">Nanti Saja</a>
    @endif
    <button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-tvip-button bg-tvip-blue px-7 text-sm font-semibold text-white hover:bg-tvip-blue-dark disabled:opacity-60" :disabled="submitting" :aria-busy="submitting">
        <span x-text="submitting ? 'Menyimpan…' : '{{ $step === 4 ? 'Simpan & Selesaikan' : 'Simpan & Lanjutkan' }}'"></span>
    </button>
</div>

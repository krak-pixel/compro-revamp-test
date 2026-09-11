# QA Checklist — TVIP Karir V2

## Scope dan Integrasi

- [x] Home V1 tetap berada di `/` dan memakai navigation/footer shared.
- [x] Menu Karir aktif di navbar desktop, mobile, dan footer.
- [x] V2 tidak membuat profile/CV/application atau panel HR.
- [x] Apply dan Send CV menampilkan preview disabled dengan pemberitahuan V3.

## Katalog Lowongan

- [x] Hanya job published dalam periode aktif yang tampil.
- [x] Seed menyediakan 12 lowongan dan pagination enam item per halaman.
- [x] Search, departemen, posisi, lokasi, dan page tersimpan di URL.
- [x] Pilihan posisi menyempit ketika departemen dipilih.
- [x] Empty/no-results memiliki pesan dan reset filter.
- [x] Detail memakai route slug yang dapat dibagikan.
- [x] Poster memakai modal; detail/apply/send CV memakai drawer.

## Authentication

- [x] Login, register, logout menggunakan session Laravel dan CSRF.
- [x] Register berhasil kembali ke login manual.
- [x] Login memulihkan intended destination.
- [x] Error form inline; password masked dan dapat diperlihatkan lewat tombol.
- [x] Submit auth memiliki busy/disabled state dengan ukuran stabil.
- [x] Route apply dan Send CV dilindungi middleware auth.

## Accessibility dan Responsive

- [x] Kontrol utama memakai elemen button/link native dan visible focus.
- [x] Search memiliki tombol clear.
- [x] Modal/drawer mendukung Escape, focus trap, internal scroll, dan scroll lock.
- [x] Grid berubah 1/2/3 kolom; drawer menjadi full-width di mobile.
- [x] Scrollbar global terlihat dan memiliki forced-colors fallback.
- [x] 403/404/500 memakai halaman milik aplikasi.

## Verification Commands

```bash
npm run build
php artisan migrate:fresh --seed
php artisan test
vendor/bin/pint --test
```

Validasi PHP memerlukan PHP 8.3 dan dependency Composer. Browser QA wajib mencakup guest/auth hero, query/filter/pagination, poster modal, direct detail URL, protected redirect, invalid auth, narrow viewport, keyboard, dan reduced motion.

## Hasil di Workspace Ini

- [x] `npm run build` — lulus.
- [x] `node --check` untuk Alpine/Vite/Tailwind dan `git diff --check` — lulus.
- [x] Premium static UI audit mode strict — 0 finding.
- [ ] `php artisan test`, migration, dan Pint — menunggu environment dengan PHP 8.3 serta dependency Composer.
- [ ] Browser QA visual/interaksi — menunggu server Laravel yang dapat dijalankan.

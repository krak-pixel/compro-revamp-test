# QA Checklist Fase Home

## Implementasi

- [x] Home memakai satu route `/`
- [x] Tentang Kami memakai anchor `#tentang-kami`
- [x] Kontak Kami memakai anchor `#kontak-kami`
- [x] Offset navbar 64px memakai `scroll-mt-16`
- [x] Link Karir ditampilkan nonaktif tanpa route Karir
- [x] Tombol primary memakai gradient `#0a3254` ke `#0f4c81`
- [x] Watermark Visi, Misi, dan S.U.P.E.R Team memakai opacity 20%
- [x] Gambar S.U.P.E.R Team memakai rotasi 11.86 derajat
- [x] Card kontak memakai alignment tengah
- [x] Aset Figma disimpan permanen di `public/images/tvip`
- [x] Form kontak menyimpan data dan mengirim notifikasi email
- [x] Form memakai CSRF, validasi, honeypot, dan rate limit

## Kontras Warna

- `#4a5565` pada `#ffffff`: 7.56:1
- `#4a5565` pada `#ecf5ff`: 6.86:1
- `#4a5565` pada `#e6eef5`: 6.45:1
- `#0f4c81` pada `#ffffff`: 8.86:1
- `#101828` pada `#ffffff`: 17.75:1
- `#000000` pada `#ecf5ff`: 19.07:1

Seluruh kombinasi teks utama di atas melewati WCAG AA untuk teks normal.

## Validasi Lokal yang Sudah Dijalankan

- PHP syntax lint untuk file PHP dan Blade
- JavaScript syntax check untuk Alpine, Vite, PostCSS, dan Tailwind config
- Pemeriksaan keberadaan aset lokal yang dirujuk oleh komponen

Pengujian runtime Laravel, migration, Vite build, dan feature test dijalankan setelah `composer install` serta `npm install` pada mesin yang memiliki akses paket.

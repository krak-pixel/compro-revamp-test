# TVIP Company Profile

Project Laravel untuk website TVIP Versi 3: Home company profile dari V1, katalog Karir V2, dan portal profil/lamaran kandidat V3.

## Stack

- Laravel 13
- Blade
- Tailwind CSS
- Alpine.js
- MySQL
- Laravel Mail

## Fitur yang Sudah Disiapkan

- Home single page sesuai struktur Figma
- Navbar fixed dengan anchor scroll dan scroll-spy
- Hero, Visi, Misi, S.U.P.E.R Team, Kontak, CTA, dan Footer
- Aset gambar serta SVG Figma disimpan permanen di `public/images/tvip`
- Form kontak dalam modal Alpine.js
- Penyimpanan ke tabel `contact_messages`
- Email notifikasi ke admin
- CSRF, validasi server, honeypot, dan rate limit 5 submit per menit
- SEO dasar, `robots.txt`, structured data, dan sitemap lowongan aktif yang dinamis
- Feature test untuk Home dan form kontak
- Portal Karir dinamis dengan 12 seed lowongan, search, filter, dan pagination
- Poster modal serta drawer detail yang memiliki route slug
- Registrasi, login manual, session intended redirect, state kandidat login, dan logout
- Wizard profil kandidat empat langkah, ringkasan/edit profil, dan riwayat lamaran
- Upload foto, CV, ijazah, dan paklaring ke private storage dengan akses berbasis pemilik
- Submission lamaran spesifik dan talent pool dengan snapshot serta pencegahan duplikasi
- Feature test untuk katalog, autentikasi, profil, dokumen privat, dan aplikasi kandidat

## Instalasi

```bash
cp .env.example .env
composer install
php artisan key:generate
npm install
```

Buat database MySQL bernama `tvip_company_profile`, lalu sesuaikan nilai `DB_*` di `.env`.

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

Untuk development:

```bash
composer run dev
```

## Konfigurasi Email

Isi konfigurasi SMTP berikut pada `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_FROM_ADDRESS=noreply@tvip.co.id
MAIL_FROM_NAME=TVIP
CONTACT_ADMIN_EMAIL=admin@tvip.co.id
```

## Catatan Scope Versi

- V2: portal publik, lowongan dinamis, poster/detail, dan autentikasi kandidat.
- V3: profil kandidat, dokumen privat, submission lamaran/talent pool, dan riwayat kandidat.
- V4: panel dan workflow HR.
- Status lamaran V3 dimulai dari **Menunggu**; perubahan status dan akses HR tetap tersedia pada V4.
- Sebelum production, konfigurasi antivirus/object storage serta kebijakan tujuan, consent, akses, dan retensi data kandidat wajib disetujui.
- Media sosial dan legal ditampilkan sebagai teks non-interaktif sampai URL resmi tersedia; tidak ada tautan `#` palsu.
- Form kontak muncul sebagai modal agar tampilan utama tetap mengikuti node Figma yang tidak menampilkan form dalam kondisi default.

## Struktur View

```text
resources/views/
├── components/
│   ├── layouts/app.blade.php
│   ├── layouts/auth.blade.php
│   ├── layouts/candidate.blade.php
│   ├── button.blade.php
│   ├── card.blade.php
│   ├── icon-wrapper.blade.php
│   ├── navigation.blade.php
│   ├── hero-section.blade.php
│   ├── vision-mission-section.blade.php
│   ├── contact-section.blade.php
│   ├── contact-form-modal.blade.php
│   └── footer.blade.php
├── career/
│   ├── auth/
│   ├── profile/
│   └── index.blade.php
├── emails/contact-message-received.blade.php
└── home.blade.php
```

PRD, design system, implementation notes, dan QA checklist tersedia di folder `docs`.

## Panduan untuk Pengguna Non-Programmer

Baca file `PANDUAN-JALANKAN-UNTUK-PEMULA.md` untuk langkah instalasi dan menjalankan project di Windows menggunakan Laragon.

# TVIP Company Profile

Project Laravel untuk website TVIP Versi 2: Home company profile dari V1 ditambah portal Karir kandidat/public-first.

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
- Preview apply/Send CV yang disabled secara jujur sampai fitur profil dan CV tersedia pada V3
- Feature test untuk katalog Karir dan autentikasi kandidat

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
- V3: profil kandidat, pas foto, CV/portofolio, serta submission lamaran/talent pool.
- V4: panel dan workflow HR.
- Tabel `applications` dan panel Filament sengaja belum dibuat pada V2.
- Media sosial dan legal ditampilkan sebagai teks non-interaktif sampai URL resmi tersedia; tidak ada tautan `#` palsu.
- Form kontak muncul sebagai modal agar tampilan utama tetap mengikuti node Figma yang tidak menampilkan form dalam kondisi default.

## Struktur View

```text
resources/views/
├── components/
│   ├── layouts/app.blade.php
│   ├── layouts/auth.blade.php
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
│   └── index.blade.php
├── emails/contact-message-received.blade.php
└── home.blade.php
```

PRD, design system, implementation notes, dan QA checklist tersedia di folder `docs`.

## Panduan untuk Pengguna Non-Programmer

Baca file `PANDUAN-JALANKAN-UNTUK-PEMULA.md` untuk langkah instalasi dan menjalankan project di Windows menggunakan Laragon.

# TVIP Company Profile

Project Laravel untuk fase pertama website TVIP. Scope saat ini hanya halaman Home single page yang terdiri dari Hero, Tentang Kami, Kontak Kami, dan Footer.

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
- SEO dasar, `robots.txt`, dan `sitemap.xml`
- Feature test untuk Home dan form kontak

## Instalasi

```bash
cp .env.example .env
composer install
php artisan key:generate
npm install
```

Buat database MySQL bernama `tvip_company_profile`, lalu sesuaikan nilai `DB_*` di `.env`.

```bash
php artisan migrate
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

## Catatan Scope

- Route `/karir` belum dibuat.
- Migration `jobs` dan `applications` belum dibuat.
- Filament belum dipasang.
- Link media sosial dan link legal masih placeholder karena URL final tidak tercantum dalam dokumen sumber.
- Form kontak muncul sebagai modal agar tampilan utama tetap mengikuti node Figma yang tidak menampilkan form dalam kondisi default.

## Struktur View

```text
resources/views/
├── components/
│   ├── layouts/app.blade.php
│   ├── button.blade.php
│   ├── card.blade.php
│   ├── icon-wrapper.blade.php
│   ├── navigation.blade.php
│   ├── hero-section.blade.php
│   ├── vision-mission-section.blade.php
│   ├── contact-section.blade.php
│   ├── contact-form-modal.blade.php
│   └── footer.blade.php
├── emails/contact-message-received.blade.php
└── home.blade.php
```

Dokumen desain dan PRD tersedia di folder `docs`.

## Panduan untuk Pengguna Non-Programmer

Baca file `PANDUAN-JALANKAN-UNTUK-PEMULA.md` untuk langkah instalasi dan menjalankan project di Windows menggunakan Laragon.

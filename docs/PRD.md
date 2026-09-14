# PRD — Website Company Profile TVIP

## 1. Ringkasan Proyek

**Nama Proyek:** Website Company Profile TVIP
**Jenis:** Landing page company profile + sistem karir dengan lamaran kerja dinamis
**Tujuan:** Membangun website resmi TVIP sebagai media informasi perusahaan (distribusi & logistik) sekaligus kanal rekrutmen online yang bisa dikelola mandiri oleh tim HR.

> **Status Pengerjaan Saat Ini:** Fokus tahap pertama adalah menyelesaikan **halaman Home** (single page — Hero, Visi/Misi/S.U.P.E.R Team, Hubungi Kami, Footer) terlebih dahulu sampai selesai dan matang. **Halaman Karir (listing lowongan + form lamar kerja + admin panel Filament) dikerjakan belakangan, setelah halaman Home selesai** — lihat Section 8 (Out of Scope Fase Ini) dan Section 9 (Milestone).

## 2. Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel (PHP) |
| Templating | Blade |
| Styling | Tailwind CSS |
| Interaktivitas | Alpine.js |
| Database | MySQL |
| Admin Panel | Laravel Filament |
| Icon | Lucide / Heroicons (SVG) |
| Hosting (rekomendasi) | VPS / shared hosting cPanel yang support PHP 8.2+ & MySQL |

## 3. Target Pengguna

1. **Calon mitra bisnis / klien** — mencari info perusahaan, layanan, cara menghubungi.
2. **Calon pelamar kerja** — mencari info lowongan dan melamar langsung via website.
3. **Admin/HR internal TVIP** — mengelola konten lowongan kerja dan melihat data pelamar.

## 4. Struktur Halaman (Sitemap)

**Fase saat ini — halaman Home sebagai single page dengan anchor scroll:**

```
/                   → Home (single page)
                       ├─ #hero              → Hero Section
                       ├─ #tentang-kami      → Section Visi, Misi, S.U.P.E.R - TEAM
                       │                        (menu navbar "Tentang Kami" scroll ke sini)
                       └─ #kontak-kami       → Section Hubungi Kami
                                                (menu navbar "Kontak Kami" scroll ke sini)
```

Menu "Tentang Kami" dan "Kontak Kami" di navbar **bukan link ke halaman terpisah**, melainkan **anchor link** yang melakukan smooth scroll ke section terkait di halaman Home yang sama (pakai native `<a href="#id">` + `scroll-smooth` dari Tailwind, atau Alpine.js kalau butuh offset scroll karena navbar sticky).

**Fase berikutnya (dikerjakan setelah Home selesai):**

```
/karir              → Karir (listing lowongan, dinamis dari database)
/karir/{slug}       → Detail Lowongan + Form Lamar Kerja
/admin              → Admin Panel (Filament, protected login)
```

## 5. Fitur per Halaman

### 5.1 Home (single page — FOKUS PENGERJAAN SAAT INI)

- **Navbar sticky:** Logo TVIP, menu (Home, Tentang Kami, Kontak Kami, Karir)
  - **Home** → link ke `/` (top of page)
  - **Tentang Kami** → anchor scroll ke `#tentang-kami` (section Visi/Misi/S.U.P.E.R Team di bawah), **bukan halaman terpisah**
  - **Kontak Kami** → anchor scroll ke `#kontak-kami` (section Hubungi Kami), **bukan halaman terpisah**
  - **Karir** → link ke `/karir` (dikerjakan di fase berikutnya, lihat Section 8)
  - Highlight menu aktif: underline biru pendek `#0f4c81`, bisa pakai scroll-spy (Alpine.js/Intersection Observer) untuk otomatis highlight menu sesuai section yang sedang dilihat user
- **Hero section:**
  - Headline besar: "Solusi Distribusi & Logistik Terbaik untuk Pertumbuhan Bisnis Anda."
  - Deskripsi singkat perusahaan
  - 2 CTA: tombol solid "Hubungi Kami" (scroll ke `#kontak-kami`) + link teks "Pelajari Lebih Lanjut" (scroll ke `#tentang-kami`)
  - Gambar gedung kantor TVIP dengan overlay logo 3D
  - Floating card statistik: "50.000+ Mitra Distribusi" dengan icon truck
- **Section `#tentang-kami` — Visi/Misi/S.U.P.E.R Team** (3 kolom card):
  - Card Visi (dengan foto gedung + icon building)
  - Card Misi (dengan foto tangan menanam + icon)
  - Card S.U.P.E.R Team (dengan foto tim + breakdown 5 poin: Solusi, Unggul, Profesional, Ekosistem, Relevan)
  - Section ini yang dituju saat menu "Tentang Kami" di navbar diklik
- **Section `#kontak-kami` — Hubungi Kami:**
  - 3 card kontak: Email, Telepon, Kantor Pusat
  - CTA banner "Siap Bermitra dengan TVIP?" dengan 2 tombol: "Hubungi Sekarang" & "Kirim Email"
  - Section ini yang dituju saat menu "Kontak Kami" di navbar diklik
- **Footer:** logo, alamat, kontak, link navigasi (anchor sama seperti navbar), link media sosial, copyright

> Catatan: karena Tentang Kami dan Kontak Kami sekarang berupa section di dalam halaman Home (bukan route terpisah), route `/tentang-kami` dan `/kontak-kami` **tidak dibuat** di fase ini. Kalau nanti dibutuhkan halaman penuh terpisah (misal Tentang Kami butuh konten lebih panjang: sejarah, struktur organisasi), itu bisa jadi pengembangan lanjutan — didiskusikan lagi setelah Home selesai.

## 7. Non-Functional Requirements

- **SEO:** setiap halaman punya meta title & description unik, sitemap.xml otomatis (termasuk halaman lowongan dinamis), URL slug rapi (`/karir/staff-logistik-jakarta`)
- **Performa:** target skor Google PageSpeed ≥ 90 (mobile & desktop); gambar dioptimasi (WebP, lazy load); Tailwind CSS di-build dengan JIT (hanya class terpakai)
- **Responsif:** wajib mobile-friendly, breakpoint minimal: mobile (< 640px), tablet (640–1024px), desktop (> 1024px)
- **Keamanan:** CSRF protection (built-in Laravel), validasi & sanitasi upload file, rate limiting pada form submission untuk cegah spam
- **Aksesibilitas:** kontras warna cukup (khususnya teks di atas gambar hero), alt text pada semua gambar

## 8. Out of Scope (Fase Ini)

- **Halaman/fitur Karir secara keseluruhan** (listing lowongan, detail lowongan, form lamar kerja, admin panel Filament, migration `jobs`/`applications`) — **dikerjakan setelah halaman Home selesai dan sudah final**, bukan dikerjakan paralel
- Halaman Tentang Kami / Kontak Kami sebagai route terpisah (`/tentang-kami`, `/kontak-kami`) — untuk saat ini cukup sebagai anchor section di halaman Home
- Akun login untuk pelamar (cek status lamaran mandiri) — bisa jadi fase 2
- Multi-bahasa (ID/EN) — bisa jadi fase 2
- Blog/artikel perusahaan — bisa jadi fase 2

## 9. Milestone Pengembangan (Saran)

**Tahap 1 — Halaman Home (fokus saat ini, selesaikan sampai final sebelum lanjut ke Tahap 2):**
1. Setup project Laravel + Tailwind + struktur Blade dasar
2. Bangun halaman Home sebagai single page (Hero, section `#tentang-kami`, section `#kontak-kami`, Footer) sesuai `DESIGN-FIGMA.md`
3. Implementasi navbar dengan anchor scroll (Tentang Kami → `#tentang-kami`, Kontak Kami → `#kontak-kami`) + scroll-spy untuk highlight menu aktif
4. Setup form Kontak Kami (submit ke tabel `contact_messages` + email notifikasi)
5. Optimasi SEO (meta tag, sitemap) & performa (image optimization) khusus untuk halaman Home
6. Testing responsif di berbagai device + QA anchor scroll & form validation
7. Review & sign-off halaman Home selesai

**Tahap 2 — Fitur Karir (mulai setelah Tahap 1 selesai & disetujui):**
8. Setup database & migration (`jobs`, `applications`)
9. Bangun route `/karir` (listing + detail + form lamar kerja)
10. Setup Filament admin panel untuk kelola lowongan & pelamar
11. Setup email notification lamaran kerja (Laravel Mail)
12. Testing & QA khusus fitur Karir
13. Deploy ke hosting/VPS

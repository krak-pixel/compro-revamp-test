# DESIGN SYSTEM — TVIP Versi 2: Karir (Sumber: Figma "compro")

> Diambil langsung dari Figma file `yn2rF2dwEivl7pQow9EBXp` melalui delapan frame halaman Karir dan alur lamaran.
> Semua nilai visual berlabel **Figma** di bawah berasal dari node sumber. Aturan responsif, aksesibilitas, dan state tambahan berlabel **panduan implementasi** karena tidak seluruhnya ditampilkan sebagai frame terpisah di Figma.

> **Status Pengerjaan:** Design System ini telah dipetakan ke implementasi **Versi 2 — halaman Karir** di atas fondasi Versi 1. Header, footer, logo, dan identitas merek tetap menjadi komponen bersama. Drawer konfirmasi lamaran dan pengiriman CV hadir sebagai preview disabled; profil, CV, serta submission menjadi Versi 3 dan panel HR menjadi Versi 4.

## Sumber Frame Figma

| Node | Nama/Peran Frame | Cakupan Utama |
|---|---|---|
| `1:756` | Karir Page — Logout View | Hero guest, filter, job grid, pagination, CTA, footer |
| `1:1153` | Karir Page — Login View | Hero pengguna login, profil kandidat, katalog lowongan |
| `1:105` | Login Page | Form login kandidat |
| `1:152` | Register Page | Form pendaftaran kandidat |
| `1:1563` | Poster View | Lightbox poster lowongan |
| `1:1974` | Sheet: Detail Lowongan | Drawer detail posisi dan kualifikasi |
| `1:2457` | Sheet: Lamar | Drawer konfirmasi lamaran |
| `1:2936` | Sheet: Kirim CV Sekarang | Drawer data kandidat dan pemilihan posisi |

## 1. Palet Warna (Hex Asli)

### 1.1 Warna Merek dan Netral

| Token | Hex | Kegunaan |
|---|---|---|
| `primary-blue` | `#0f4c81` | Aksen merek, tombol utama, link, judul aktif, ujung gradient |
| `primary-blue-dark` | `#0a3254` | Awal gradient hero dan tombol primary |
| `primary-blue-light` | `#1a6ab3` | Ujung terang gradient hero/auth |
| `text-heading` | `#101828` | Heading, judul lowongan, nilai data kandidat |
| `text-strong` | `#1e2939` | Teks kuat sekunder pada detail/form |
| `text-label` | `#364153` | Label form dan menu navigasi nonaktif |
| `text-body` | `#4a5565` | Paragraf, isi deskripsi, teks sekunder utama |
| `text-muted` | `#6a7282` | Metadata lowongan, email, label data kandidat |
| `text-placeholder` | `#717182` | Placeholder field dan select |
| `text-disabled` | `#99a1af` | Teks/icon pada state nonaktif |
| `text-control` | `#333333` | Teks kontrol netral/outline |
| `white` | `#ffffff` | Surface utama dan teks di atas warna gelap |
| `surface-subtle` | `#f9fafb` | Preview kandidat dan surface sangat ringan |
| `surface-muted` | `#f3f4f6` | Background icon, tombol close, badge netral |
| `border-default` | `#e5e7eb` | Border field, panel, divider, drawer footer |
| `border-strong` | `#d1d5dc` | Border avatar dan kontrol outline kuat |
| `required` | `#fb2c36` | Tanda wajib pada label form |

### 1.2 Gradient

| Token | Nilai | Kegunaan |
|---|---|---|
| `gradient-brand` | `linear-gradient(90deg, #0a3254 0%, #0f4c81 100%)` | Tombol primary dan elemen aksi bermerek |
| `gradient-hero` | `linear-gradient(90deg, #0a3254 0%, #0f4c81 60%, #1a6ab3 100%)` | Hero Karir dan background halaman autentikasi |
| `overlay-modal` | `rgba(0, 0, 0, 0.60)` | Backdrop poster dan drawer |
| `surface-on-dark-soft` | `rgba(255, 255, 255, 0.10)` | Badge dan tombol close di atas backdrop/hero |
| `border-on-dark-soft` | `rgba(255, 255, 255, 0.20)` | Border badge transparan di atas hero |

### 1.3 Warna Badge Kategori

| Varian | Background | Teks | Contoh |
|---|---|---|---|
| `info-blue` | `#dbeafe` | `#1447e6` | Sales |
| `neutral-gray` | `#f3f4f6` | `#4a5565` | Staff |
| `success-green` | `#dcfce7` | `#008236` | Operations |
| `danger-red` | `#ffe2e2` | `#c10007` | Manager |
| `indigo` | `#e0e7ff` | `#432dd7` | Supervisor |
| `orange` | `#ffedd4` | `#ca3500` | Logistik |

```js
// tailwind.config.js — contoh mapping token
colors: {
  'tvip-blue': '#0f4c81',
  'tvip-blue-dark': '#0a3254',
  'tvip-blue-light': '#1a6ab3',
  'tvip-heading': '#101828',
  'tvip-label': '#364153',
  'tvip-body': '#4a5565',
  'tvip-muted': '#6a7282',
  'tvip-surface': '#f9fafb',
  'tvip-surface-muted': '#f3f4f6',
  'tvip-border': '#e5e7eb',
}
```

## 2. Tipografi

Font: **Inter** (`400 Regular`, `500 Medium`, `600 Semi Bold`, `700 Bold`).

| Token/Elemen | Size | Weight | Line-height | Warna |
|---|---:|---:|---:|---|
| Hero H1 Karir | 48px | 700 | 60px | `#ffffff` |
| Hero paragraf | 17px | 400 | 27.625px | `#dbeafe` |
| Heading auth | 24px | 700 | 32px | `#101828` |
| Angka statistik hero | 24px | 700 | 38.4px | `#ffffff` |
| Heading CTA | 22px | 700 | 35.2px | `#ffffff` |
| Heading drawer | 20px | 700 | 28px | `#101828` |
| Judul posisi di drawer | 18px | 600 | 28px | `#101828` |
| Judul card lowongan | 16px | 600 | 25.6px | `#101828` |
| Heading section detail | 16px | 600 | 25.6px | `#101828` |
| Tombol utama | 16px | 500–600 | 22–25.6px | putih / sesuai varian |
| Menu navbar | 16px | 400–500 | 25.6px | putih / `#364153` sesuai konteks |
| Body dan metadata | 14px | 400 | 20px | `#4a5565` / `#6a7282` |
| Label form | 14px | 500 | 20px | `#364153` |
| Nilai data kandidat | 14px | 500 | 20px | `#101828` |
| Badge kategori | 12px | 500–600 | 16px | sesuai varian badge |

Aturan penggunaan:

- Heading menggunakan `700` hanya untuk hirarki utama. Judul card dan heading isi memakai `600` agar tidak bersaing dengan hero.
- Body copy tidak boleh lebih kecil dari `14px`; badge adalah satu-satunya pola utama berukuran `12px`.
- Gunakan font fallback `Inter, ui-sans-serif, system-ui, sans-serif` agar layout tetap stabil ketika font belum selesai dimuat.

## 3. Border Radius

| Token | Radius | Elemen |
|---|---:|---|
| `radius-full` | `9999px` | Badge “We Are Hiring”, badge kategori, icon bulat |
| `radius-3xl` | `24px` | Card login/register dan CTA banner |
| `radius-2xl` | `16px` | Filter panel, job card, poster lightbox |
| `radius-card-soft` | `14px` | Card preview kandidat |
| `radius-xl` | `10px` | Tombol utama, pagination |
| `radius-lg` | `8px` | Input, select, tombol drawer, avatar |

> Figma mengekspor radius pill sebagai angka sangat besar. Di kode, normalkan menjadi `9999px` atau `rounded-full`.

## 4. Shadow / Elevation

| Token/Elemen | Box-shadow |
|---|---|
| Navbar | `0 1px 1.5px rgba(0,0,0,0.10), 0 1px 1px rgba(0,0,0,0.10)` |
| Job card | `0 1px 3px rgba(0,0,0,0.10), 0 1px 2px -1px rgba(0,0,0,0.10)` |
| Filter/pagination aktif | `0 4px 3px rgba(0,0,0,0.10), 0 2px 2px rgba(0,0,0,0.10)` |
| CTA banner | `0 10px 15px -3px rgba(0,0,0,0.10), 0 4px 6px -4px rgba(0,0,0,0.10)` |
| Auth card | `0 25px 25px rgba(0,0,0,0.25)` |
| Poster/drawer | `0 25px 50px -12px rgba(0,0,0,0.25)` |
| Judul di atas poster | `0 3px 3px rgba(0,0,0,0.12)` |

Prinsip elevation: gunakan shadow untuk membedakan layer, bukan sebagai dekorasi. Card dalam page memakai elevation rendah; auth card dan overlay memakai elevation tinggi.

## 5. Layout & Spacing

### 5.1 Desktop — Halaman Karir

- **Lebar frame referensi Figma:** sekitar `1482–1490px`.
- **Max content width:** `1280px`.
- **Margin horizontal frame referensi:** sekitar `101px`.
- **Padding internal section:** `32px` bila section memakai wrapper tambahan.
- **Navbar:** tinggi `64px`.
- **Hero:** tinggi `700px`, termasuk area wave putih di bagian bawah.
- **Hero content:** mulai setelah navbar dengan jarak atas sekitar `80px`; lebar copy utama sekitar `672px`.
- **Filter panel:** lebar `1280px`, padding horizontal `24px`, padding vertikal `32px`, gap `16px`.
- **Search/filter control:** tinggi sekitar `42px`, radius `8px`.
- **Job grid:** 3 kolom × 2 baris, total 6 lowongan per halaman, gap sekitar `24px`.
- **Poster pada job card:** tinggi `208px`, `object-cover`.
- **Job card body:** padding horizontal `20px`, padding vertikal `20px`, gap internal `16px`.
- **Pagination:** tombol `36 × 36px`, gap `8px`.
- **CTA banner:** `1280 × 186px`, padding `48px`, radius `24px`.
- **Footer:** gunakan kembali layout dan token footer Versi 1.

### 5.2 Auth Page

- **Canvas referensi:** `1490 × 944px` dengan `gradient-hero` sebagai background penuh.
- **Kolom auth:** lebar `448px`, diletakkan di tengah.
- **Login card:** `448 × 556px`, padding sekitar `40px`, radius `24px`.
- **Area input:** lebar `368px`.
- **Logo:** sekitar `112 × 29px`.
- Link kembali diletakkan di atas card, bukan di dalam card.

### 5.3 Overlay dan Drawer

- **Backdrop:** hitam `60%`, menutup viewport.
- **Poster lightbox:** maksimal `896 × 896px`, radius `16px`, center-aligned.
- **Close poster:** `40 × 40px`, posisi `24px` dari kanan dan atas viewport.
- **Drawer:** lebar `600px`, tinggi viewport, menempel di kanan.
- **Drawer content:** padding `32px`; lebar konten efektif sekitar `536px`.
- **Close drawer:** `36 × 36px`, `16px` dari atas dan `24px` dari kanan.
- **Footer drawer:** sticky di bawah, divider atas, area aksi selebar konten.

### 5.4 Spacing Scale

Gunakan kelipatan 4px agar konsisten dengan ukuran Figma:

| Token | Nilai | Contoh |
|---|---:|---|
| `space-1` | 4px | Jarak mikro/icon |
| `space-2` | 8px | Gap badge, pagination |
| `space-3` | 12px | Gap label dan control kecil |
| `space-4` | 16px | Gap card dan form standar |
| `space-5` | 20px | Padding preview card |
| `space-6` | 24px | Padding panel/card |
| `space-8` | 32px | Padding drawer/filter vertikal |
| `space-10` | 40px | Padding auth card |
| `space-12` | 48px | Gap grid dan padding CTA |
| `space-20` | 80px | Offset atas hero content |

## 6. Layout Tree

Struktur komponen gabungan untuk Versi 2:

- `CareerPage`
  - `Navigation` — shared dari Versi 1; menu **Karir** aktif
  - `CareerHero`
    - `HiringBadge`
    - heading dan deskripsi
    - `GuestActions` — Login, Daftar; atau
    - `CandidateSummary` — state pengguna login
    - `CareerStats`
    - wave separator
  - `JobFilterPanel`
    - `SearchField`
    - `LocationSelect`
    - `DepartmentSelect`
    - `EmploymentTypeSelect`
  - `JobListingSection`
    - `JobCardGrid`
      - 6 × `JobCard`
    - `Pagination`
  - `CareerCtaBanner`
  - `Footer` — shared dari Versi 1
- `AuthLayout`
  - back link
  - logo
  - `LoginForm` atau `RegisterForm`
- `PosterModal`
- `JobDetailDrawer`
- `ApplyConfirmationDrawer`
- `SendCvDrawer`
  - `CandidatePreviewCard`
  - position select
  - drawer actions

**Urutan implementasi yang disarankan:**

1. Gabungkan token Karir dengan token global Versi 1 tanpa menduplikasi nilai.
2. Bangun primitive reusable: button, input, select, badge, overlay, drawer.
3. Aktifkan route dan menu Karir pada navigation/footer shared.
4. Bangun hero, filter, job card grid, pagination, dan CTA.
5. Bangun auth layout dan form.
6. Bangun poster modal serta rangkaian drawer detail → lamar → kirim CV.
7. Tambahkan state loading, kosong, error, disabled, keyboard, dan responsive.

## 7. Komponen Detail

### 7.1 Button Primary — Gradient

```css
background: linear-gradient(90deg, #0a3254 0%, #0f4c81 100%);
border-radius: 10px;
padding: 10px 24px;
color: #ffffff;
font: 500 16px/22px Inter, sans-serif;
```

- Dipakai untuk aksi utama pada hero guest, job card, auth, dan CTA.
- Lebar penuh pada job card dan form auth.
- Drawer memakai versi solid `#0f4c81`, radius `8px`, tinggi sekitar `36px`.
- State disabled pada Figma Kirim CV menggunakan opacity `50%`; cursor dan handler juga wajib dinonaktifkan.

### 7.2 Button Secondary / Outline

- Background transparan atau putih sesuai surface.
- Border `1px solid #d1d5dc` untuk surface terang.
- Pada hero, gunakan border putih `2px` dengan teks putih.
- Radius `8–10px`; label `14–16px Medium`.
- Tombol **Batal** di drawer selalu memiliki emphasis lebih rendah dari aksi submit.

### 7.3 Hiring Badge

- Tinggi `36px`, lebar mengikuti konten (sekitar `152px`).
- Background putih `10%`, border putih `20%`, `rounded-full`.
- Icon `16px`, label `14px Medium`, warna putih.

### 7.4 Search dan Filter Panel

- Surface putih, border `#e5e7eb`, radius `16px`.
- Search dan select setinggi sekitar `42px`, radius `8px`.
- Icon field sekitar `16–20px`, teks input `14px`.
- Search harus memiliki tombol clear saat berisi teks (**panduan implementasi**).
- Query, filter, dan page disarankan tersimpan pada URL agar state dapat dibagikan dan dipulihkan (**panduan implementasi**).

### 7.5 Job Card

- Surface putih, border lembut `#f3f4f6`, radius `16px`, elevation rendah.
- Poster memenuhi lebar card, tinggi `208px`, `object-cover`.
- Isi card memakai padding `20px` dan gap internal `16px`.
- Judul posisi: `16px Semi Bold`, warna `#101828`.
- Metadata: `14px Regular`, warna `#6a7282`, icon `16px`.
- Badge kategori boleh lebih dari satu dan wrap ke baris berikutnya.
- Aksi utama selebar card. Seluruh card tidak otomatis menjadi tombol; gunakan link/button semantik pada target interaksi.

### 7.6 Badge Kategori

- Font `12px`, line-height `16px`, weight `500–600`.
- Card: padding sekitar `2px 10px`.
- Drawer detail: padding dapat meningkat menjadi `4px 12px`.
- Radius full dan pasangan warna harus mengikuti tabel Section 1.3.
- Jangan mengandalkan warna saja: label kategori tetap harus eksplisit.

### 7.7 Pagination

- Tombol angka `36 × 36px`, radius `10px`, gap `8px`.
- State aktif memakai warna brand dan elevation sedikit lebih tinggi.
- Tombol previous/next harus punya accessible name; state disabled tidak menerima interaksi.
- Perubahan filter mengembalikan page ke halaman pertama (**panduan implementasi**).

### 7.8 Career CTA Banner

- Gradient brand, radius `24px`, shadow medium.
- Desktop `1280 × 186px`, padding `48px`.
- Heading `22px Bold`, deskripsi memakai warna terang sekunder.
- Tombol CTA putih dengan teks `#0f4c81`, padding sekitar `16px 32px`, radius `10px`.

### 7.9 Auth Card dan Field

- Card putih `448px`, padding sekitar `40px`, radius `24px`, shadow tinggi.
- Label `14px Medium #364153`; tanda wajib `#fb2c36`.
- Field memiliki border `#e5e7eb`, radius `8px`, teks `14px/20px`.
- Password dimask secara default dan memiliki tombol show/hide yang dapat digunakan keyboard.
- Error ditampilkan sebagai teks yang terhubung ke field; jangan hanya mengubah border menjadi merah.
- Copy tombol pada source Figma login/register masih menampilkan **“Lamar”** pada beberapa frame. Ini dianggap inkonsistensi copy; implementasi harus memakai **“Masuk”** untuk login dan **“Daftar”** untuk registrasi kecuali product owner memutuskan lain.

### 7.10 Poster Modal

- Backdrop `rgba(0,0,0,0.60)`.
- Poster maksimal `896 × 896px`, radius `16px`, shadow tinggi.
- Close button `40 × 40px`, surface putih transparan `10%`, icon `20px`.
- Gambar tidak boleh diregangkan; gunakan containment yang mempertahankan aspect ratio.
- Escape, klik backdrop, focus trap, dan focus restoration mengikuti primitive modal aplikasi (**panduan implementasi**).

### 7.11 Job Detail Drawer

- Lebar desktop `600px`, surface putih, menempel di kanan viewport.
- Header visual/poster sekitar `256px` tinggi.
- Konten padding `32px`, gap section `24px`.
- Heading drawer `20px Bold`; judul posisi `18px Semi Bold`.
- Metadata memakai icon `16px` dan body `14px/20px`.
- Kualifikasi menggunakan check icon `16px`; teks tetap menjadi sumber informasi utama.
- Isi drawer harus scroll internal saat lebih tinggi dari viewport; header/footer tidak boleh membuat action hilang.

### 7.12 Apply Confirmation Drawer

- Menggunakan shell drawer yang sama dengan detail lowongan.
- Footer memiliki divider atas dan dua aksi dengan lebar seimbang: **Batal** dan **Lamar Sekarang**.
- Tinggi tombol sekitar `36px`, radius `8px`.
- Tombol utama solid `#0f4c81`; Batal menggunakan emphasis netral.
- Saat submit, ukuran tombol tetap stabil dan submit ganda dicegah (**panduan implementasi**).

### 7.13 Send CV Drawer

- Candidate preview memakai background `#f9fafb`, border `#e5e7eb`, radius `14px`, padding sekitar `20px`.
- Avatar `64 × 64px`, radius `8px`, border `2px solid #d1d5dc`.
- Nama `16px Semi Bold`; email `14px Regular #6a7282`.
- Label data `14px Regular #6a7282`; value `14px Medium #101828` dalam grid dua kolom.
- Select minat posisi setinggi `42px`, radius `8px`, placeholder `#717182`.
- Tombol submit disabled sampai data wajib valid; Figma menunjukkan opacity `50%`.

### 7.14 Navigation dan Footer Shared

- Gunakan komponen Versi 1 agar logo, spacing, link, dan responsive navigation tidak bercabang.
- Menu **Karir** aktif pada `/karir`; Home, Tentang Kami, dan Kontak Kami tetap menuju route/anchor Versi 1.
- Di atas hero gelap, navigation dapat memakai varian on-dark sesuai frame Karir; di halaman lain tetap gunakan varian putih Versi 1.
- Link Karir yang sebelumnya disabled harus menjadi link semantik aktif pada navbar dan footer.

## 8. State dan Perilaku Interaksi

| Komponen/Alur | State Wajib |
|---|---|
| Career page | guest, authenticated, loading, loaded, empty, no-results, error |
| Search/filter | idle, focused, filled, clearable, active, disabled |
| Job card | default, hover, keyboard focus, poster open, action loading |
| Pagination | default, hover, active, disabled |
| Auth form | empty, filled, invalid, submitting, server error, success |
| Modal/drawer | closed, opening, open, loading, error, closing |
| Apply flow | eligible, unauthenticated, missing profile/CV, ready, submitting, success, failure |

Alur visual utama:

1. Pengunjung membuka `/karir`, mencari atau memfilter lowongan.
2. Poster dapat dibuka pada `PosterModal`; informasi lengkap dibuka pada `JobDetailDrawer`.
3. Aksi melamar mengarahkan guest ke autentikasi atau melanjutkan pengguna login ke `ApplyConfirmationDrawer`.
4. Jika profil/CV belum lengkap, gunakan `SendCvDrawer`; submit aktif setelah data wajib valid.
5. Setelah berhasil, tampilkan feedback yang jelas dan cegah pengiriman ganda.

## 9. Aset Gambar & Icon (dari Figma)

> URL asset yang dihasilkan Figma bersifat sementara. Semua gambar dan SVG harus diekspor ke storage proyek sebelum implementasi production.

Gambar utama:

- Poster lowongan untuk setiap job card.
- Poster resolusi besar untuk lightbox/detail.
- Avatar kandidat pada preview data.
- Logo TVIP horizontal pada navbar dan auth card.
- Shape/wave putih pemisah hero dengan konten.

Icon yang terlihat pada desain:

- Search, chevron select, location, department/briefcase, employment type.
- User/profile, mail, phone, calendar/metadata kandidat.
- Arrow/back, eye/show password, close (`X`).
- Check untuk kualifikasi.
- Arrow pagination.

Gunakan SVG asli dari Figma bila bentuknya custom. Untuk icon utilitas generik, gunakan satu icon set yang sudah dipakai Versi 1; jangan mencampur beberapa library dengan stroke berbeda.

## 10. Responsive dan Accessibility

Bagian ini adalah **panduan implementasi**, karena node yang diberikan terutama menampilkan desktop.

### 10.1 Responsive

| Rentang | Aturan |
|---|---|
| Desktop `≥ 1200px` | Grid 3 kolom, content max `1280px`, drawer `600px` |
| Tablet `768–1199px` | Grid 2 kolom, filter wrap menjadi 2 baris, spacing section diperkecil |
| Mobile `< 768px` | Grid 1 kolom, filter stack, CTA stack, drawer menjadi full-width |

- Gunakan padding horizontal minimum `16px` pada mobile dan `24–32px` pada tablet/desktop.
- Hero tidak mempertahankan tinggi kaku `700px` jika konten membungkus; gunakan `min-height`.
- Auth card memakai `width: min(448px, calc(100vw - 32px))`.
- Poster lightbox dibatasi oleh lebar dan tinggi viewport; kontrol close tetap terlihat.
- Pada mobile, drawer menjadi sheet full-screen dan action footer aman terhadap safe-area.

### 10.2 Accessibility

- Target minimum **WCAG 2.2 AA**.
- Gunakan `<button>` untuk aksi dan `<a>` untuk navigasi; jangan memakai `div` clickable.
- Semua state hover memiliki pasangan visible focus.
- Icon-only button memiliki accessible name, misalnya “Tutup detail lowongan”.
- Modal/drawer modal menggunakan focus trap, background inert, Escape, dan focus restoration.
- Label form terhubung ke control; error memakai `aria-invalid` dan `aria-describedby`.
- Badge tidak menjadi satu-satunya pembawa makna berbasis warna.
- Cegah layout shift dengan aspect ratio poster, ruang error form, dan ukuran tombol yang stabil.
- Hormati `prefers-reduced-motion`; animasi drawer cukup transform/fade singkat dan tidak wajib untuk memahami alur.

## 11. Design Rules — Do's & Don'ts

### Do's ✅

- Gunakan token Section 1–5; jangan mengambil warna baru dari screenshot dengan perkiraan.
- Reuse navigation, footer, logo, dan primitive yang sudah ada di Versi 1.
- Gunakan pasangan warna badge yang sudah ditentukan.
- Jaga hirarki: hero `48px`, drawer `20px`, judul posisi `16–18px`, body `14px`.
- Pertahankan aspect ratio poster dan gunakan `object-cover`/`object-contain` sesuai konteks.
- Sediakan state loading, empty, no-results, error, disabled, hover, dan focus.
- Pertahankan data filter ketika user kembali dari detail/auth bila secara teknis memungkinkan.

### Don'ts ❌

- Jangan membuat design system terpisah yang menduplikasi token Versi 1.
- Jangan mengganti gradient hero dengan warna solid.
- Jangan memakai shadow tinggi pada semua card; elevation tinggi hanya untuk overlay/auth.
- Jangan membuat seluruh job card menjadi elemen klik nonsemantik.
- Jangan menampilkan tombol submit enabled ketika CV/field wajib belum valid.
- Jangan memakai browser `alert()`, `confirm()`, atau `prompt()` untuk alur lamaran.
- Jangan mempertahankan copy tombol “Lamar” pada halaman login/register tanpa keputusan produk.
- Jangan menyembunyikan scrollbar drawer; konten panjang harus tetap dapat diakses.

## 12. Catatan untuk AI Coding Tool

Saat mengimplementasikan desain ini ke repository Versi 1:

1. Baca dokumen ini bersama `PRD-KARIR-V2.md`, design system Versi 1, dan komponen runtime yang sudah ada.
2. Jadikan token global sebagai single source of truth; tambahkan hanya token yang belum tersedia.
3. Pecah UI berdasarkan Layout Tree, bukan berdasarkan satu file Blade besar.
4. Pertahankan stack repository saat ini (Laravel Blade, Tailwind CSS, dan Alpine.js) kecuali ada keputusan teknis eksplisit untuk berubah.
5. Gunakan data lowongan terstruktur untuk menghasilkan job card, badge, metadata, poster, dan isi drawer.
6. Gunakan satu primitive overlay/drawer reusable untuk detail, konfirmasi, dan kirim CV.
7. Bedakan state guest dan authenticated pada server serta UI; jangan mengandalkan tampilan saja untuk otorisasi.
8. Ekspor asset Figma secara permanen dan simpan dengan nama semantik; jangan menyimpan URL asset sementara Figma.
9. Verifikasi hasil terhadap semua delapan node sumber pada desktop, lalu uji breakpoint tablet/mobile dan keyboard.
10. Perlakukan ukuran Figma sebagai baseline desktop. Jangan memaksakan pixel absolut yang menyebabkan overflow atau layout rusak pada viewport lain.

## 13. Definition of Done Visual

- Seluruh delapan frame sumber memiliki padanan route/state yang jelas.
- Token warna, typography, radius, shadow, dan spacing diambil dari dokumen ini.
- Grid desktop menampilkan 3 kolom dan maksimal 6 card per halaman seperti Figma.
- Guest/authenticated hero, auth forms, poster modal, dan tiga state drawer tervalidasi.
- Navigation/footer Versi 1 tetap konsisten dan link Karir sudah aktif.
- Tidak ada asset Figma sementara, copy placeholder, atau kontrol tanpa state focus/disabled.
- Hasil akhir lolos perbandingan visual desktop serta pengujian responsive dan accessibility dasar.

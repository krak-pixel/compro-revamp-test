# DESIGN SYSTEM — TVIP (Sumber: Figma "Compro Dot4")

> Diambil langsung dari Figma via node `343:778` — "Landing Page: Home, Tentang Kami, Kontak Kami".
> File: `DoumhkxHYEpvTYrLffAv6V`
> Semua nilai di bawah ini adalah token asli dari file Figma, bukan estimasi visual.

> **Status Pengerjaan:** Dokumen ini mencakup desain **halaman Home** yang menjadi fokus pengerjaan saat ini. Meskipun nama frame Figma-nya "Landing Page: Home, Tentang Kami, Kontak Kami", secara implementasi **ketiganya jadi satu halaman (single page)** — "Tentang Kami" dan "Kontak Kami" bukan halaman terpisah, melainkan **section di dalam halaman Home** yang dituju lewat anchor scroll dari menu navbar (lihat Section 6 — Layout Tree, dan catatan navigasi di Section 7.6). Desain untuk halaman **Karir** belum tercakup di dokumen ini — akan dibuatkan dokumentasi terpisah setelah halaman Home selesai.

## 1. Palet Warna (Hex Asli)

| Token | Hex | Kegunaan |
|---|---|---|
| `primary-blue` | `#0f4c81` | Heading utama, judul VISI/MISI/S.U.P.E.R, teks "Hubungi Kami" section, link email/telepon, menu nav aktif, ujung gradient tombol |
| `primary-blue-dark` | `#0a3254` | Awal gradient tombol primary |
| `text-heading` | `#101828` | Heading card (Email/Telepon/Kantor Pusat), heading footer, angka statistik "50.000+" |
| `text-body` | `#4a5565` | Paragraf deskripsi di seluruh halaman (hero, card kontak, footer, CTA banner) |
| `text-nav-inactive` | `#364153` | Teks menu navbar yang tidak aktif |
| `text-black` | `#000000` | Paragraf isi card Visi/Misi & isi S.U.P.E.R Team |
| `text-cta-secondary` | `#333333` | Teks tombol outline "Kirim Email" |
| `bg-light-blue-card` | `#ecf5ff` | Background card Visi / Misi / S.U.P.E.R Team |
| `bg-light-blue-section` | `#e6eef5` | Background section Kontak (full-width), background lingkaran icon (stat card, contact card) |
| `bg-social-icon` | `#f3f4f6` | Background lingkaran icon sosial media di footer |
| `border-outline-btn` | `#d1d5dc` | Border tombol outline "Kirim Email" |
| `border-divider` | `#e5e7eb` | Garis pemisah tipis di atas copyright footer |
| `white` | `#ffffff` | Background utama, card kontak, floating stat card |

```js
// tailwind.config.js
colors: {
  'tvip-blue': '#0f4c81',
  'tvip-blue-dark': '#0a3254',
  'tvip-heading': '#101828',
  'tvip-body': '#4a5565',
  'tvip-nav': '#364153',
  'tvip-light-card': '#ecf5ff',
  'tvip-light-section': '#e6eef5',
  'tvip-social-bg': '#f3f4f6',
}
```

## 2. Tipografi

Font: **Inter** (Bold / Semi Bold / Medium / Regular)

| Elemen | Size | Weight | Line-height | Warna |
|---|---|---|---|---|
| Hero H1 | 60px | Bold | 75px | `#0f4c81` |
| Hero paragraf | 18px | Regular | 29.25px | `#4a5565` |
| Tombol (semua) | 14px | Medium | 20px | putih / `#0a0a0a` |
| Judul VISI / MISI / S.U.P.E.R | 32px | Bold | 48px | `#0f4c81` |
| Paragraf card Visi/Misi | 16px | Regular | 24px | `#000000` |
| S.U.P.E.R item — label (mis. "Solusi :") | 16px | Bold, tracking 0.16px | 24px | `#000000` |
| S.U.P.E.R item — deskripsi | 14px | Regular | 21px | `#000000` |
| Angka statistik "50.000+" | 16px | Semi Bold | 24px | `#101828` |
| Label statistik "Mitra Distribusi" | 14px | Regular | 20px | `#4a5565` |
| Judul section "Hubungi Kami" | 48px | Bold | 48px | `#0f4c81` |
| Subjudul section Kontak | 18px | Regular | 28px | `#4a5565` |
| Judul card kontak (Email/Telepon/Kantor Pusat) | 24px | Semi Bold | 32px | `#101828` |
| Deskripsi card kontak | 16px | Regular | 26px | `#4a5565` |
| Detail kontak (email/telepon/alamat) | 16px | Medium | 25.6px | `#0f4c81` |
| Judul CTA banner "Siap Bermitra..." | 30px | Bold | 36px | `#101828` |
| Deskripsi CTA banner | 18px | Regular | 28px | `#4a5565` |
| Judul kolom footer (Perusahaan/Media Sosial) | 16px | Semi Bold | 25.6px | `#101828` |
| Link/isi footer | 16px | Regular | 25.6px | `#4a5565` |
| Copyright & link legal | 14px | Regular | 20px | `#4a5565` |
| Menu navbar | 16px | Regular | 25.6px | `#0f4c81` (aktif) / `#364153` (nonaktif) |

## 3. Border Radius

| Elemen | Radius |
|---|---|
| Container gambar hero | `40px` |
| Floating card statistik ("50.000+") | `16px` |
| Card Visi / Misi / S.U.P.E.R Team | `24px` |
| Tombol hero ("Hubungi Kami", "Pelajari Lebih Lanjut") | `8px` |
| Card kontak (Email/Telepon/Kantor Pusat) | `16px` |
| Card CTA banner "Siap Bermitra" | `24px` |
| Tombol CTA banner ("Hubungi Sekarang", "Kirim Email") | `10px` |
| Icon lingkaran (stat card, contact card icon, social icon) | full circle (`9999px`) |

## 4. Shadow / Elevation

| Elemen | Box-shadow |
|---|---|
| Container gambar hero | `0px 25px 50px -12px rgba(0,0,0,0.25)` |
| Floating card statistik | `0px 10px 7.5px rgba(0,0,0,0.1), 0px 4px 3px rgba(0,0,0,0.1)` |
| Card Visi / Misi / S.U.P.E.R Team | `0px 16px 32px -4px rgba(12,12,13,0.1), 0px 4px 4px -4px rgba(12,12,13,0.05)` |
| Card kontak (Email/Telepon/Kantor Pusat) | `0px 1px 1.5px rgba(0,0,0,0.1), 0px 1px 1px rgba(0,0,0,0.1)` |
| Card CTA banner "Siap Bermitra" | `0px 10px 7.5px rgba(0,0,0,0.1), 0px 4px 3px rgba(0,0,0,0.1)` |
| Navbar (sticky) | `0px 1px 1.5px rgba(0,0,0,0.1), 0px 1px 1px rgba(0,0,0,0.1)` |

## 5. Layout & Spacing

- **Max content width:** `1280px`, dengan padding horizontal luar `101px` (navbar `105px`)
- **Padding dalam container:** `32px` di kiri-kanan tiap section
- **Navbar height:** `64px`, sticky, background putih + shadow tipis
- **Hero section:** tinggi total `944px`, padding-top `64px` (ruang untuk navbar), 2 kolom (`568px` + `568px`) dengan gap
- **Vision/Mission/Team section:** padding-top `140px`, 3 card dengan lebar `338px`, `338px`, `493px` (card ketiga lebih lebar karena isi S.U.P.E.R Team lebih banyak)
- **Contact section:** background `#e6eef5` full-width, padding vertikal `80px`, 3 card kontak lebar `384px` masing-masing dengan gap `32px`
- **Footer:** padding-top `64px`, 3 kolom (Info kantor `373px`, Perusahaan `381px`, Media Sosial `381px`), lalu divider + copyright bar

## 6. Layout Tree

Struktur hierarki komponen sesuai node Figma, berguna sebagai peta referensi saat memecah desain jadi komponen/section kode.

```
Landing Page: Home, Tentang Kami, Kontak Kami [343:778]
├─ Navigation [343:1012]                          (sticky, height 64px)
│  ├─ Logo TVIP [343:1014]
│  └─ Menu [343:1015]
│     ├─ Home (aktif, underline)                 → link ke "/" (top of page)
│     ├─ Tentang Kami                            → anchor scroll ke #tentang-kami (section Visi/Misi/S.U.P.E.R di bawah)
│     ├─ Kontak Kami                              → anchor scroll ke #kontak-kami (section Hubungi Kami di bawah)
│     └─ Karir                                    → link ke "/karir" (fase berikutnya, belum dikerjakan)
│
└─ HomePage [343:779]
   ├─ Main Content [343:780]
   │  ├─ HeroSection [343:781]                   (height 944px)
   │  │  ├─ Kolom Kiri [343:784]
   │  │  │  ├─ Heading H1
   │  │  │  ├─ Paragraf deskripsi
   │  │  │  └─ Container Tombol
   │  │  │     ├─ Button "Hubungi Kami" (primary/gradient)
   │  │  │     └─ Button "Pelajari Lebih Lanjut" (text link)
   │  │  └─ Kolom Kanan [343:793]
   │  │     ├─ Container Gambar (rounded 40px, overlay logo TVIP)
   │  │     └─ Floating Card Statistik ("50.000+ Mitra Distribusi")
   │  │
   │  ├─ VisionMissionSection [343:811]           (height 947px, 3 card, id="tentang-kami")
   │  │  ├─ Card VISI [343:814]                   (338px)
   │  │  │  ├─ Gambar (gedung)
   │  │  │  ├─ Judul "VISI" + icon
   │  │  │  ├─ Deskripsi
   │  │  │  └─ Watermark icon (opacity 20%)
   │  │  ├─ Card MISI [343:837]                   (338px)
   │  │  │  ├─ Gambar (tangan menanam)
   │  │  │  ├─ Judul "MISI" + icon
   │  │  │  ├─ Deskripsi "Tumbuh Bersama"
   │  │  │  └─ Watermark icon (opacity 20%)
   │  │  └─ Card S.U.P.E.R Team [343:858]         (493px, lebih lebar)
   │  │     ├─ Gambar (tim, dirotasi ~12°)
   │  │     ├─ Judul "S.U.P.E.R - TEAM" + icon
   │  │     ├─ 5x SuperItem [343:876–889]
   │  │     │  ├─ Solusi
   │  │     │  ├─ Unggul
   │  │     │  ├─ Profesional
   │  │     │  ├─ Ekosistem
   │  │     │  └─ Relevan
   │  │     └─ Watermark icon besar (opacity 20%)
   │  │
   │  └─ ContactSection [343:896]                 (bg #e6eef5, height ~986px, id="kontak-kami")
   │     ├─ Heading "Hubungi Kami" + subjudul
   │     ├─ 3x Card Kontak [343:902, 912, 921]
   │     │  ├─ Card Email
   │     │  ├─ Card Telepon
   │     │  └─ Card Kantor Pusat
   │     └─ Card CTA Banner [343:931]              (bg putih, rounded 24px)
   │        ├─ Judul "Siap Bermitra dengan TVIP?"
   │        ├─ Deskripsi
   │        └─ Container Tombol
   │           ├─ Button "Hubungi Sekarang" (primary/gradient)
   │           └─ Button "Kirim Email" (outline)
   │
   └─ Footer [343:941]                            (height ~588px)
      ├─ Kolom Info Kantor [343:944]
      │  ├─ Logo TVIP
      │  ├─ Kantor Pusat (alamat)
      │  ├─ Kontak (telepon, email)
      │  └─ Social Icons (Facebook, Instagram, Twitter, LinkedIn)
      ├─ Kolom "Perusahaan" [343:977]
      │  └─ Link: Home, Tentang Kami, Kontak Kami, Karir
      ├─ Kolom "Media Sosial" [343:989]
      │  └─ Link: Facebook, Instagram, X (Twitter), LinkedIn
      └─ Bottom Bar [343:1001]
         ├─ Copyright
         └─ Link legal: Kebijakan Privasi, Syarat dan Ketentuan, Pengaturan Cookies
```

**Urutan implementasi yang disarankan** (dari komponen paling reusable ke paling spesifik):
1. Design tokens (warna, font, spacing, radius, shadow) → base setup
2. Komponen atomic: Button (primary/outline), Card (base), Icon wrapper
3. Navigation
4. HeroSection
5. VisionMissionSection (termasuk 3 varian card)
6. ContactSection (card kontak + CTA banner)
7. Footer

## 7. Komponen Detail

### 6.1 Tombol Primary (gradient)
```css
background: linear-gradient(to right, #0a3254, #0f4c81);
border-radius: 8px; /* atau 10px untuk tombol besar di CTA banner */
padding: 12px 32px;
color: white;
font: 14px/16px Inter Medium;
```

### 6.2 Tombol Outline (secondary)
```css
background: transparent;
border: 1px solid #d1d5dc;
border-radius: 10px;
color: #333333;
```

### 6.3 Floating Stat Card (di atas gambar hero)
- Background putih, `rounded-2xl` (16px), shadow soft
- Icon dalam lingkaran `48px`, background `#e6eef5`
- Angka `16px semibold #101828`, label `14px regular #4a5565`

### 6.4 Card Visi/Misi/S.U.P.E.R Team
- Background `#ecf5ff`, radius `24px`
- Gambar di bagian atas (`object-cover`, tinggi ±197–228px, sedikit di-crop/zoom)
- Ada watermark icon besar dengan **opacity 20%** di pojok kanan bawah tiap card — detail dekoratif penting yang sering terlewat
- Card S.U.P.E.R Team lebih lebar (493px) dan memuat 5 sub-item (Solusi, Unggul, Profesional, Ekosistem, Relevan), masing-masing: label bold 16px + deskripsi 14px

### 6.5 Card Kontak
- Background putih, radius `16px`, shadow sangat tipis
- Icon dalam lingkaran `64px`, background `#e6eef5`, posisi center
- Semua teks di dalam card center-aligned
- Detail kontak (email/telepon/alamat) pakai warna primary blue `#0f4c81`, weight medium

### 6.6 Navbar
- Height `64px`, background putih, shadow tipis, sticky
- Menu aktif ("Home") diberi garis bawah kecil (`2px`, warna `#0f4c81`, rounded, lebar mengikuti teks) — bukan underline penuh
- Menu tidak aktif warna `#364153`
- **Perilaku navigasi menu (penting):**
  - **Home** → link biasa ke `/` (top of page)
  - **Tentang Kami** → **anchor scroll** ke `#tentang-kami` (section Visi/Misi/S.U.P.E.R Team), bukan pindah halaman
  - **Kontak Kami** → **anchor scroll** ke `#kontak-kami` (section Hubungi Kami), bukan pindah halaman
  - **Karir** → link ke halaman terpisah `/karir` (fase berikutnya)
  - Karena navbar sticky (`height: 64px`), smooth scroll harus pakai offset supaya section tidak ketutup navbar, misalnya `scroll-margin-top: 64px` pada elemen section, atau hitung offset manual kalau pakai Alpine.js
  - Highlight menu aktif idealnya mengikuti section yang sedang terlihat di viewport (scroll-spy), bukan cuma state klik terakhir

## 8. Aset Gambar & Icon (dari Figma)

> ⚠️ Catatan penting: URL asset di bawah ini di-generate otomatis oleh Figma dan **hanya valid selama 7 hari**. Export ulang / download permanen sebelum dipakai di production.

Gambar yang dipakai:
- Foto gedung kantor TVIP + overlay logo 3D (hero)
- Foto gedung (card Visi)
- Foto tangan menanam bibit (card Misi)
- Foto tangan tim berkolaborasi, sedikit dirotasi ~12° (card S.U.P.E.R Team)
- Logo TVIP (navbar & footer, format horizontal)

Icon (SVG, custom vector — bukan icon set standar seperti Lucide/Heroicons):
- Icon truck (stat "50.000+ Mitra Distribusi")
- Icon building (VISI)
- Icon plant/sprout (MISI)
- Icon star/badge (S.U.P.E.R Team, dan watermark besarnya)
- Icon mail, phone, map-pin (3 card kontak)
- Icon Facebook, Instagram, Twitter/X, LinkedIn (footer)

**Rekomendasi:** karena icon asli adalah custom SVG dari desainer, sebaiknya export langsung dari Figma (klik kanan → Export → SVG) daripada mengganti dengan Lucide/Heroicons supaya bentuknya tetap identik dengan desain.

## 9. Design Rules — Do's & Don'ts

### Do's ✅
- Gunakan color palette yang sudah *defined* di Section 1 — semua warna (background, teks, border) harus diambil dari token yang sudah ditentukan
- Konsisten dengan spacing scale kelipatan **4px** (4, 8, 12, 16, 24, 32, 48, 64px, dst) — cocok dengan nilai gap/padding yang muncul di Section 5 & 6
- Ikuti typography hierarchy sesuai Section 2 — tiap level heading/body punya size, weight, dan warna yang sudah ditetapkan, jangan buat level baru di luar itu
- Test kontras warna untuk accessibility, minimum **WCAG AA** (rasio kontras ≥ 4.5:1 untuk teks normal, ≥ 3:1 untuk teks besar/heading) — khususnya teks di atas gambar hero dan teks `#4a5565` di atas background `#ecf5ff`/`#e6eef5`
- Gunakan border radius yang konsisten sesuai Section 3 — card besar pakai `16px`–`24px`, tombol pakai `8px`–`10px`, jangan campur nilai lain

### Don'ts ❌
- Jangan pakai **arbitrary colors** di luar palette — kalau butuh warna baru, tambahkan dulu ke token di Section 1, jangan hardcode hex baru langsung di komponen
- Jangan pakai **random padding/margin values** (mis. `13px`, `27px`) — selalu bulatkan ke kelipatan 4px terdekat yang sudah ada di spacing scale
- Jangan **mixing multiple font families** — seluruh UI hanya pakai **Inter**, jangan tambah font lain meski cuma untuk satu elemen kecil
- Jangan ubah **shadow** (nilai di Section 4) tanpa approval — shadow ini bagian dari brand identity visual, perubahan sekecil apa pun (blur, opacity, offset) harus dikonfirmasi dulu
- Jangan **mixing different spacing scale** — jangan gabungkan sistem 4px ini dengan skala lain (mis. 5px, 10px, 15px) dalam komponen yang sama, supaya grid tetap konsisten di seluruh halaman

## 10. Catatan untuk AI Coding Tool
1. Gunakan warna hex **persis** seperti tabel di atas — jangan dibulatkan ke warna Tailwind default (mis. jangan pakai `blue-900` bawaan, tapi custom `#0f4c81`)
2. Tombol primary **wajib gradient** (`#0a3254` → `#0f4c81`), bukan solid color
3. Perhatikan watermark icon opacity 20% di card Visi/Misi/S.U.P.E.R — detail kecil ini bagian dari desain, jangan dihilangkan
4. Radius card konsisten besar (`16px`–`24px`), jangan diperkecil
5. Semua shadow harus soft/menyebar sesuai nilai di atas, hindari shadow default browser yang tajam
6. Font wajib Inter dengan weight sesuai tabel (Bold/Semi Bold/Medium/Regular) — jangan campur dengan font default sistem
7. Ikuti aturan Do's & Don'ts di Section 9 secara ketat — ini acuan utama saat AI generate atau ubah kode agar desain tetap konsisten
8. **Home adalah single page** — jangan buat route/file Blade terpisah untuk "Tentang Kami" dan "Kontak Kami". Keduanya adalah `<section id="tentang-kami">` dan `<section id="kontak-kami">` di dalam halaman Home yang sama, dituju lewat anchor scroll dari navbar
9. **Jangan implementasikan fitur Karir dulu** (listing lowongan, form lamar, admin panel) — di luar scope pengerjaan saat ini. Selesaikan dan review halaman Home terlebih dahulu sebelum lanjut ke fitur Karir

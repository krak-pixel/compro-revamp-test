# DESIGN SYSTEM — TVIP Versi 3: Form Kandidat dan Riwayat Lamaran

> Diambil langsung dari Figma file `yn2rF2dwEivl7pQow9EBXp` melalui delapan frame Form Kandidat Versi 3.
> Nilai yang disebut **Figma** berasal dari node sumber. Aturan mobile, accessibility, validation, security feedback, dan state yang tidak memiliki frame khusus disebut **panduan implementasi**.

> **Status Pengerjaan:** Dokumen ini merupakan acuan pra-implementasi Versi 3 di atas fondasi Versi 1 dan Versi 2. Implementasi harus tetap memakai Laravel Blade, Tailwind CSS, Alpine.js, token TVIP, auth kandidat, dan primitive yang sudah tersedia. Panel HR tetap menjadi Versi 4.

## Sumber Frame Figma

| Node | Nama/Peran Frame | Cakupan Utama |
|---|---|---|
| `1:3385` | Form Kandidat: Data Induk | Step 1 kosong/incomplete, upload dan biodata |
| `1:3849` | Form Kandidat: Data Detail | Step 2, kontak, alamat, dan data fisik |
| `1:3973` | Form Kandidat: Data Pendidikan | Step 3, SMA/SMK dan empty state perguruan tinggi |
| `1:4107` | Data Pengalaman — Fresh Graduate | Step 4 tanpa pengalaman kerja |
| `1:4205` | Data Pengalaman — Ada Pengalaman | Step 4 dengan blok pengalaman panjang |
| `1:3539` | Formulir Lengkap | Read-only, complete badge, riwayat kosong |
| `1:3698` | Edit Mode | Data tersimpan dalam mode edit dan aksi Batal Edit |
| `1:4482` | Riwayat Lamaran | Data tersimpan dengan item lamaran berstatus Menunggu |

Frame Versi 2 yang tetap digunakan:

- `1:2457` — drawer konfirmasi lamaran;
- `1:2936` — drawer Kirim CV Sekarang/talent pool;
- `1:1974` — detail lowongan;
- `1:756` dan `1:1153` — halaman Karir guest/login.

## 1. Prinsip Integrasi Design System

1. Token global Versi 1 dan token Karir Versi 2 tetap menjadi single source of truth.
2. Warna, radius, shadow, input, button, badge, dan icon yang sama tidak dibuat ulang dengan nama berbeda.
3. Versi 3 menambah pola khusus: page header kandidat, horizontal stepper, form section, upload field, repeatable education/work card, locked history, completed state, dan application history item.
4. Reference code React dari Figma MCP tidak digunakan langsung. Struktur diterjemahkan ke Blade components dan Alpine.js.
5. Width/height Figma adalah baseline desktop, bukan ukuran absolut untuk semua viewport.

## 2. Palet Warna

### 2.1 Warna Inti yang Digunakan Kembali

| Token | Hex | Kegunaan V3 |
|---|---|---|
| `tvip-blue` | `#0f4c81` | Heading, step aktif, link, tombol, icon utama |
| `tvip-blue-dark` | `#0a3254` | Awal gradient tombol utama |
| `text-heading` | `#101828` | Judul dan nilai data kuat |
| `text-strong` | `#1e2939` | Heading subsection/pengalaman |
| `text-label` | `#364153` | Label field dan body kuat |
| `text-body` | `#4a5565` | Deskripsi dan teks pendukung |
| `text-muted` | `#6a7282` | Subtitle, metadata, secondary copy |
| `text-placeholder` | `#717182` | Placeholder input/textarea |
| `text-disabled` | `#99a1af` | Step belum aktif, field/read-only copy |
| `surface-page` | `#f9fafb` | Background halaman kandidat |
| `surface-white` | `#ffffff` | Header dan card form |
| `border-default` | `#e5e7eb` | Border card, field, divider, connector inactive |
| `border-strong` | `#d1d5dc` | Border upload dashed dan kontrol kuat |

### 2.2 Warna State Baru/Spesifik V3

| Token | Hex | Kegunaan |
|---|---|---|
| `step-complete` | `#00c950` | Lingkaran check dan connector step selesai |
| `info-surface` | `#eff6ff` | Surface informasi/locked history |
| `info-border` | `#bedbff` | Border card/info biru |
| `info-icon-surface` | `#dbeafe` | Latar icon informasi/riwayat |
| `info-text` | `#1447e6` | Copy informasi kecil |
| `success-surface` | `#f0fdf4` | Badge formulir lengkap |
| `success-border` | `#b9f8cf` | Border badge complete |
| `success-text` | `#008236` | Teks/icon formulir lengkap |
| `warning-surface` | `#fefce8` | Badge status Menunggu |
| `warning-border` | `#fff085` | Border status Menunggu |
| `warning-text` | `#a65f00` | Teks status Menunggu |
| `danger` | `#fb2c36` | Required/error/delete; reuse token V2 |

### 2.3 Gradient

| Token | Nilai | Kegunaan |
|---|---|---|
| `gradient-brand` | `linear-gradient(90deg, #0a3254 0%, #0f4c81 100%)` | Tombol Selanjutnya dan Simpan Formulir |
| `gradient-info-card` | Gradien ringan dari `#eff6ff` menuju putih | Panel Riwayat Lamaran locked/incomplete |

```js
// tailwind.config.js — tambahkan hanya jika token belum tersedia
colors: {
  'tvip-step-complete': '#00c950',
  'tvip-info-surface': '#eff6ff',
  'tvip-info-border': '#bedbff',
  'tvip-success-surface': '#f0fdf4',
  'tvip-success-border': '#b9f8cf',
  'tvip-success-text': '#008236',
  'tvip-warning-surface': '#fefce8',
  'tvip-warning-border': '#fff085',
  'tvip-warning-text': '#a65f00',
}
```

## 3. Tipografi

Font tetap **Inter** dengan fallback `ui-sans-serif, system-ui, sans-serif`.

| Elemen | Size | Weight | Line-height | Warna |
|---|---:|---:|---:|---|
| Page title “Form Kandidat” | 20px | 700 | 28px | `#0f4c81` |
| Step/form section title | 18px | 600 | 28px | `#0f4c81` |
| Section group title | 16px | 600 | ±25.6px | `#0f4c81` / `#1e2939` |
| History title | 18px | 600 | 28px | `#0f4c81` |
| Step label | 14px | 500 | 20px | aktif `#101828`, inactive `#99a1af` |
| Header subtitle | 14px | 400 | 20px | `#6a7282` |
| Field label | 14px | 500 | 20px | `#364153` |
| Field value/placeholder | 14px | 400 | 20px | value `#1f2937`, placeholder `#717182` |
| Button label | 14px | 500–600 | 20px | sesuai varian |
| Helper/step description | 12px | 400 | 16px | `#99a1af` / `#6a7282` |
| Status badge | 12–14px | 500 | 16–20px | sesuai state |

Aturan penggunaan:

- Heading halaman hanya satu dan menggunakan struktur heading semantik.
- “Step 1…” tidak boleh menjadi satu-satunya penanda urutan; stepper dan heading form harus konsisten.
- Helper text minimum `12px` hanya untuk informasi sekunder. Error penting sebaiknya `14px`.
- Long-form responsibilities dan alasan resign memakai line-height minimal `20px`.

## 4. Border Radius

| Token | Radius | Elemen |
|---|---:|---|
| `radius-full` | `9999px` | Step circle, icon circle, status pill |
| `radius-card` | `14px` | Main form card dan history panel |
| `radius-control` | `8px` | Input, textarea, upload, button, info strip |

Figma mengekspor radius pill sebagai `33554400px`; implementasi harus menormalkannya menjadi `rounded-full`.

## 5. Shadow dan Border

| Elemen | Nilai/Arah |
|---|---|
| Main form card | Border `1px #e5e7eb`; shadow rendah sekitar `0 1px 1.5px rgba(0,0,0,.10), 0 1px 1px rgba(0,0,0,.10)` |
| History locked card | Border `1px #bedbff`; shadow rendah yang sama |
| Input/select/textarea | Border `1px #e5e7eb`; tanpa shadow default |
| Upload field | Border dashed `1px #d1d5dc`; tanpa shadow |
| Experience/education nested card | Border `1px #e5e7eb`; surface putih/subtle |
| Header | Border bawah `1px #e5e7eb`; tanpa elevation tinggi |

Shadow tidak boleh dipakai untuk menyatakan error atau required state. Error menggunakan border, icon, teks, dan hubungan `aria-describedby`.

## 6. Layout Desktop

### 6.1 Canvas dan Wrapper

- **Lebar frame Figma:** `1482px` pada seluruh node.
- **Background:** `#f9fafb`.
- **Header:** tinggi `81px`, full width.
- **Main wrapper:** lebar `1024px`, berada pada x `229px` pada frame referensi.
- **Main form card:** lebar `960px`, offset `32px` di dalam wrapper.
- **Inner form content:** lebar sekitar `894px`, padding card `32–33px`.
- **Stepper region:** `1024 × 150px`, padding horizontal sekitar `40px`, vertikal `32px`.
- **Main gap:** card langsung mengikuti stepper; history panel berjarak sekitar `16px`.

Ketinggian frame berubah mengikuti state:

| Node/State | Tinggi Frame Figma |
|---|---:|
| Data Pengalaman Fresh Graduate `1:4107` | `955px` |
| Data Detail `1:3849` | `1183px` |
| Data Induk `1:3385` | `1311px` |
| Data Pendidikan `1:3973` | sekitar `1330px` |
| Riwayat Lamaran `1:4482` | `1377px` |
| Formulir Lengkap `1:3539` | `1415px` |
| Data Pengalaman Ada Pengalaman `1:4205` | sekitar `2456px` |

Implementasi tidak menggunakan fixed page height; seluruh section mengikuti tinggi konten.

### 6.2 Grid Form

- Field pendek menggunakan grid dua kolom dengan gap `16px`.
- Lebar kolom pada inner `894px` adalah sekitar `439px`.
- Field full width dipakai untuk KTP, alamat, CV, pendidikan, responsibilities, dan blok pengalaman tertentu.
- Input/select standar tinggi `42px`.
- Textarea alamat baseline `64px`; responsibilities dan alasan resign dapat lebih tinggi sesuai konten.
- Upload field baseline `48px` setelah label.
- Label-to-control gap `8px`.
- Gap antar-row utama `16px`.

### 6.3 Form Actions

- Ditempatkan di kanan bawah card.
- Gap tombol `8px`.
- Tombol baseline Figma tinggi `36px`, radius `8px`.
- **Panduan implementasi:** area sentuh dinaikkan menjadi minimal `44px` pada mobile tanpa mengubah proporsi desktop secara berlebihan.

## 7. Layout Tree dan Komponen

```text
CandidateProfilePage
├─ CandidatePageHeader
│  ├─ BackButton
│  ├─ PageTitleAndSubtitle
│  └─ ProfileStateActions
├─ CandidateStepper
│  └─ 4 × CandidateStep
├─ CandidateFormCard
│  ├─ FormSectionHeader
│  ├─ StepContent
│  └─ FormStepActions
└─ ApplicationHistoryPanel
   ├─ LockedHistoryState
   ├─ EmptyHistoryState
   └─ ApplicationHistoryList
```

Komponen Blade yang disarankan:

- `x-career.candidate.page-header`
- `x-career.candidate.stepper`
- `x-career.candidate.form-card`
- `x-career.candidate.field`
- `x-career.candidate.upload-field`
- `x-career.candidate.education-card`
- `x-career.candidate.experience-card`
- `x-career.candidate.history-panel`
- `x-career.candidate.status-badge`

Nama final mengikuti konvensi repository dan tidak wajib identik bila komponen existing sudah mencakup kebutuhan yang sama.

## 8. Komponen Detail

### 8.1 Candidate Page Header

- Surface putih, border bawah, tinggi baseline `81px`.
- Content align dengan wrapper utama.
- Back button berbentuk icon button `36px` pada Figma.
- Judul `20px Bold #0f4c81`; subtitle `14px Regular #6a7282`.
- State incomplete hanya menampilkan title/subtitle.
- State complete menampilkan `CompleteBadge` dan **Edit Form** di kanan.
- State edit mengganti group kanan menjadi **Batal Edit**.
- Back button dan Batal Edit wajib memiliki visible focus dan accessible name.

### 8.2 Candidate Stepper

- Empat step horizontal dengan connector.
- Lingkaran step `40 × 40px`.
- Icon check di dalam step complete `20px`.
- Connector sekitar `131px × 2px` pada desktop baseline.
- Step title `14px Medium`; subtitle `12px Regular`.

State:

| State | Circle | Connector Sebelumnya | Label |
|---|---|---|---|
| Upcoming | `#e5e7eb`, nomor `#6a7282` | abu-abu | `#99a1af` |
| Current | `#0f4c81`, nomor putih | sesuai progress | `#101828` |
| Complete | `#00c950`, check putih | hijau | `#101828` |

Stepper harus menggunakan elemen list. Step yang dapat dikunjungi ulang menggunakan button/link; upcoming yang belum eligible bukan elemen klik palsu.

### 8.3 Main Form Card

- Surface putih, border `#e5e7eb`, radius `14px`, shadow rendah.
- Width desktop `960px`, padding `32px`.
- Section title `18px Semi Bold #0f4c81`.
- Subtitle `14px Regular #6a7282`, jarak `4px` dari title.
- Gap antara header dan form sekitar `16–24px`, disesuaikan kompleksitas step.
- Error summary muncul setelah header dan sebelum field pertama tanpa menggeser heading secara membingungkan.

### 8.4 Field Text, Number, Date, Select, dan Textarea

- Control height `42px`, radius `8px`, border `#e5e7eb`.
- Horizontal padding `16px` untuk input; textarea dapat memakai `12px`.
- Label `14px Medium #364153`; asterisk required tidak menjadi satu-satunya penjelasan.
- Placeholder `#717182`; value `#1f2937`.
- Focus menggunakan ring/border brand dengan kontras AA.
- Read-only complete state menggunakan surface subtle dan tetap memiliki kontras yang cukup; jangan mengandalkan opacity rendah seperti mockup ekspor.
- Disabled hanya dipakai jika field benar-benar tidak dapat berinteraksi. Data tersimpan yang perlu dibaca lebih tepat memakai `readonly` atau semantic description list.

### 8.5 Upload Field

- Label field di atas area upload.
- Area baseline `48px`, radius `8px`, border dashed `#d1d5dc`.
- Icon upload `16px`, label `14px`.
- Copy sumber:
  - **Pilih foto JPG/PNG (Max 5MB)**
  - **Pilih file PDF (Max 5MB)**
  - **Format PDF (max 5MB)** / **Click to upload** pada paklaring.
- Uploaded state menampilkan filename seperti `bordir (1).pdf` dan action replace.
- Pas foto complete state menampilkan preview `96 × 128px` dan tombol **Ganti Foto**.
- Hidden native file input tetap dapat dioperasikan keyboard dan terhubung dengan label.
- State error, uploading, success, dan scanning harus mempertahankan tinggi minimum agar layout stabil.

### 8.6 Button

#### Primary

```css
background: linear-gradient(90deg, #0a3254 0%, #0f4c81 100%);
border-radius: 8px;
min-height: 36px;
padding: 8px 16px;
font: 600 14px/20px Inter, sans-serif;
color: #ffffff;
```

Digunakan untuk **Selanjutnya** dan **Simpan Formulir**.

#### Tertiary/Previous

- Transparan, teks `#0a0a0a`, icon panah `16px`.
- Label **Sebelumnya**.
- Pada step pertama dapat tetap tampil disabled sesuai Figma, tetapi harus memiliki state disabled semantik.

#### Edit/Cancel

- **Edit Form** memakai icon edit dan teks brand.
- **Batal Edit** memakai emphasis netral/teks.
- **Tambah**, **Tambah Pengalaman**, dan **Ganti Foto** menggunakan tertiary brand action.

Button wajib memiliki state default, hover, focus-visible, active, disabled, loading, dan error-recoverable. Label loading tidak boleh mengubah lebar tombol secara drastis.

### 8.7 Data Induk Section

- Urutan field mengikuti node `1:3385`.
- Pas foto dan CV full-width.
- Nama dan KTP full-width.
- Tanggal/tempat lahir menggunakan dua kolom.
- Jenis kelamin/status pernikahan menggunakan dua kolom.
- Golongan darah/agama menggunakan dua kolom.
- Complete/read-only state mengikuti node `1:3539`; edit state mengikuti `1:3698`.
- Field sensitif dapat di-mask pada read-only state; desain tidak mengatur masking sehingga ini merupakan panduan implementasi.

### 8.8 Data Detail Section

- Tinggi/berat dua kolom.
- Kewarganegaraan/tempat tinggal dua kolom.
- Alamat KTP full-width textarea.
- Nomor telepon/email dua kolom.
- Alamat domisili full-width textarea.
- Email akun yang tidak dapat diubah melalui wizard menggunakan style read-only yang jelas, bukan disabled opacity berlebihan.

### 8.9 Data Pendidikan Section

- Card SMA/SMK menggunakan nested surface/border dan padding sekitar `16px`.
- Judul group `16px Semi Bold #0f4c81`.
- Nama sekolah dan bidang keahlian full-width.
- Tahun pendidikan dapat menjadi dua input kecil; nilai akhir memakai kolom tersendiri pada desktop.
- Ijazah memakai upload field full-width.
- Card perguruan tinggi opsional memiliki header, helper **Maksimal 4 jenjang pendidikan**, dan action **Tambah**.
- Empty state berada di tengah area card.
- Repeatable entry wajib menjaga nomor/heading yang stabil dan menyediakan tombol hapus dengan accessible name.

### 8.10 Data Pengalaman — Fresh Graduate

- Pilihan pengalaman menggunakan dua radio horizontal.
- Info panel biru muda mengisi lebar inner form.
- Icon dalam circle `64 × 64px`; glyph `32px`.
- Copy utama: **Anda adalah Fresh Graduate**.
- Copy pendukung menjelaskan bahwa data pengalaman tidak perlu diisi.
- Action akhir: **Sebelumnya** dan **Simpan Formulir**.

### 8.11 Data Pengalaman — Ada Pengalaman

- Intro group menampilkan judul **Pengalaman Kerja**, helper **Minimal 1, maksimal 3 perusahaan**, dan action **Tambah Pengalaman**.
- Setiap perusahaan menjadi nested card dengan heading bernomor dan delete action.
- Struktur visual menggunakan aksen vertikal biru pada Jabatan Awal dan hijau pada Jabatan Akhir.
- Field tanggal bulan/tahun dikelompokkan secara visual namun tetap memiliki label per control.
- Responsibilities memakai textarea full-width.
- Section **Informasi Resign & Lainnya** dipisahkan dengan spacing, bukan garis dekoratif berlebihan.
- Paklaring memakai upload PDF full-width.
- Node `1:4205` sangat panjang; card dan wrapper harus auto-height dan tidak menggunakan absolute positioning.

### 8.12 Formulir Lengkap dan Edit Mode

#### Complete/read-only

- Header subtitle berubah menjadi **Data tersimpan. Lanjut lamar pekerjaan.**
- Badge complete menggunakan success surface/border/text dan check icon.
- Action **Edit Form** tersedia.
- Data tampil read-only tetapi tetap terbaca.

#### Edit

- Action kanan menjadi **Batal Edit**.
- Field aktif kembali.
- Data existing menjadi nilai awal.
- File existing menampilkan preview/filename dan action replace.
- Cancel tidak boleh menghapus data tersimpan.

### 8.13 Riwayat Lamaran — Locked

- Card lebar `960px`, radius `14px`, border `#bedbff`, info gradient.
- Icon circle `64px` dengan icon koper `32px`.
- Heading **Riwayat Lamaran** `18px Semi Bold #0f4c81`.
- Deskripsi incomplete berada di tengah.
- Info strip di bagian bawah memakai `#eff6ff`, border `#bedbff`, icon `16px`, copy `12px #1447e6`.
- State ini bukan disabled button; ia adalah informative region.

### 8.14 Riwayat Lamaran — Empty

- Surface putih dengan border default.
- Heading dan subtitle rata kiri.
- Empty container berada di bawah header dengan icon koper muted.
- Copy **Belum ada lamaran**.
- Link **Kunjungi halaman Karir** menggunakan brand color dan focus state.

### 8.15 Riwayat Lamaran — Loaded

- Heading **Riwayat Lamaran** dan subtitle **Daftar lowongan yang sudah Anda lamar**.
- Item lamaran memakai surface subtle, border default, radius `8px`.
- Judul posisi memiliki emphasis paling tinggi.
- Metadata memakai icon kecil dan teks muted.
- Badge **Menunggu** menggunakan warning palette, tidak hanya warna; label teks wajib.
- Item contoh sumber: Sales Operation Support Staff, Sales, Jakarta/Tangerang, 20 Apr 2026.
- Data contoh tidak boleh di-hardcode.

## 9. State dan Perilaku Interaksi

| Komponen | State Wajib |
|---|---|
| Candidate page | loading, incomplete, draft, complete, edit, error |
| Stepper | upcoming, current, complete, blocked, clickable-complete |
| Field | empty, filled, focus, invalid, read-only, disabled |
| Upload | idle, focus/drag, uploading, uploaded, replacing, invalid, scan-pending, rejected |
| Repeatable group | empty, one item, max items, deleting, reorder-stable |
| Save action | idle, saving, saved, error, retry |
| History | locked, empty, loaded, paginating, error |
| Apply | incomplete-profile, eligible, submitting, success, duplicate, expired, failure |

Alur interaksi utama:

1. Candidate page menentukan step dari draft server.
2. **Selanjutnya** memvalidasi dan menyimpan step aktif.
3. Jika valid, focus berpindah ke heading step berikutnya.
4. **Sebelumnya** tidak membuang draft tersimpan.
5. Step 4 menggunakan conditional content berdasarkan radio.
6. **Simpan Formulir** melakukan final validation server.
7. Complete state mengaktifkan flow lamaran Versi 2.
8. Riwayat diperbarui setelah submission sukses.

## 10. Responsive

Bagian ini adalah **panduan implementasi**, karena frame sumber hanya desktop.

### 10.1 Breakpoint

| Rentang | Perilaku |
|---|---|
| Desktop `≥ 1200px` | Wrapper max `1024px`, card max `960px`, form dua kolom |
| Tablet `768–1199px` | Wrapper fluid, padding `24px`, dua kolom bila ruang cukup |
| Mobile `< 768px` | Padding `16px`, form satu kolom, action stack/wrap |

### 10.2 Header

- Header boleh auto-height ketika title/action membungkus.
- Pada mobile, back button, title, dan status action tidak boleh saling bertabrakan.
- Badge complete dan Edit Form dapat pindah ke baris kedua.

### 10.3 Stepper

- Desktop mempertahankan empat step horizontal.
- Tablet memperkecil connector dan spacing, bukan font sampai tidak terbaca.
- Mobile menggunakan progress summary ringkas “Langkah 2 dari 4” plus current label, atau horizontal scroll yang memiliki affordance jelas.
- Seluruh empat nama step tetap tersedia untuk screen reader.

### 10.4 Form dan Repeatable Cards

- Grid dua kolom menjadi satu kolom.
- Kelompok bulan/tahun dapat menjadi dua kolom kecil selama masing-masing control tetap minimal lebar layak.
- Experience card tidak memakai fixed height.
- Delete action tidak menutupi judul atau field.
- Footer actions dapat sticky hanya jika tidak menutupi konten/error dan menghormati safe-area.

## 11. Accessibility

- Target minimum WCAG 2.2 AA.
- Gunakan `<ol>` untuk stepper dan `aria-current="step"` pada step aktif.
- Step selesai memiliki label tekstual, bukan check icon saja.
- Semua input memakai `label for`; required memiliki penjelasan yang dapat dibaca assistive technology.
- Form validation menggunakan error summary dan inline error.
- Gunakan `aria-invalid`, `aria-describedby`, dan live region untuk save/upload status.
- Group Fresh Graduate/Ada Pengalaman menggunakan `fieldset`/`legend`.
- Repeatable education/experience menggunakan heading unik: “Pengalaman Kerja 1”, dst.
- Icon-only delete/back mempunyai accessible name.
- Focus order mengikuti urutan visual dan tidak masuk ke field conditional yang tersembunyi.
- Read-only data tetap selectable dan memiliki kontras yang cukup.
- Motion/scroll ke step menghormati `prefers-reduced-motion`.

## 12. Validation dan Feedback Visual

Figma tidak menyediakan frame error khusus. Gunakan pola berikut tanpa mengubah bahasa visual:

- Border error menggunakan token danger, tidak hanya shadow merah.
- Error text `14px`, diletakkan langsung setelah control.
- Error summary memakai info/error card di awal form dan menyediakan anchor ke field bermasalah.
- Success autosave ditampilkan secara tenang pada header/action region; jangan memakai toast yang hilang terlalu cepat sebagai satu-satunya feedback.
- Loading button mempertahankan width dan menggunakan spinner/icon dari sistem yang sama.
- Upload progress tidak mengganti label sehingga konteks file tetap terbaca.
- Server error tidak menghapus input valid atau draft step lain.

## 13. Penyajian Data Sensitif

- Nomor KTP pada read-only state ditampilkan masked, misalnya hanya empat digit terakhir, setelah keputusan produk.
- Alamat lengkap tidak ditampilkan pada card riwayat.
- Nama file boleh tampil; internal storage path tidak boleh tampil.
- Gaji dan kontak atasan hanya tampil pada form kandidat, bukan history summary.
- Copy consent/privacy harus dekat dengan final submit atau tersedia melalui link jelas.
- Jika review produk menghapus field sensitif, layout menutup ruangnya secara natural; jangan mempertahankan placeholder kosong demi pixel matching.

## 14. Aset Gambar dan Icon

> URL Figma MCP bersifat sementara. Asset yang dipakai production harus diekspor dan disimpan permanen di repository/storage yang tepat.

Asset utama:

- Pas foto kandidat sebagai user content, bukan asset statis.
- Icon back, upload, check, briefcase/history, edit, delete, info, plus, dan chevron.
- Tidak ada gambar dekoratif baru yang dibutuhkan untuk halaman kandidat.

Aturan:

- User-uploaded photo dan dokumen tidak disimpan dalam `public/images`.
- SVG Figma custom diekspor persis; jangan menggambar ulang path secara manual.
- Icon utilitas boleh reuse aset V2 bila glyph dan stroke benar-benar sama.
- Setiap icon memiliki container dengan width dan height eksplisit.
- Icon dekoratif memakai alt kosong/`aria-hidden`; icon bermakna memiliki accessible name melalui kontrolnya.

## 15. Do's dan Don'ts

### Do's ✅

- Reuse token, field, button, dan card Versi 2.
- Gunakan auto-layout CSS/grid/flex, bukan absolute positioning hasil ekspor Figma.
- Simpan draft per step agar form panjang tidak mudah hilang.
- Pertahankan state complete/edit/history sesuai node sumber.
- Gunakan private upload dan authorized preview.
- Sediakan loading, error, focus, read-only, disabled, success, dan empty states.
- Gunakan format data lokal pada tampilan, tetapi simpan angka/tanggal secara terstruktur.

### Don'ts ❌

- Jangan menyalin reference code React Figma ke repository Blade.
- Jangan membuat halaman setinggi angka frame Figma secara fixed.
- Jangan mengecilkan seluruh halaman agar form pengalaman muat satu layar.
- Jangan menggunakan opacity sangat rendah untuk data read-only yang masih perlu dibaca.
- Jangan menggunakan `alert()`, `confirm()`, atau `prompt()` untuk validation/delete.
- Jangan menyimpan CV, KTP, ijazah, paklaring, atau foto ke public storage.
- Jangan menampilkan storage path atau nomor KTP penuh.
- Jangan menganggap asterisk Figma sebagai persetujuan final untuk mengumpulkan data sensitif.
- Jangan menghapus dokumen lama sebelum replacement berhasil.

## 16. Catatan untuk AI Coding Tool

1. Baca dokumen ini bersama `PRD-KARIR-V3.md`, `PRD-KARIR-V2.md`, `DESIGN-FIGMA-KARIR-V2.md`, `DESIGN.md`, serta source runtime.
2. Pastikan Versi 2 sudah berada di `main`, lalu implementasikan pada `feature/career-v3`.
3. Pertahankan Laravel 13, Blade, Tailwind 3.4, Alpine.js, MySQL, dan auth session existing.
4. Tambahkan migration secara additive; jangan mengubah database dengan `migrate:fresh`.
5. Gunakan Form Request, policy, model relation, private storage, transaction, dan unique constraint.
6. Pecah UI ke Blade components sesuai Layout Tree; hindari satu template monolitik.
7. Gunakan server-rendered values sebagai sumber kebenaran; Alpine hanya membantu step UI, upload feedback, dan repeatable fields.
8. Jangan mengandalkan hidden/disabled UI untuk authorization atau eligibility.
9. Snapshot profil/job/dokumen pada submit agar riwayat stabil.
10. Verifikasi visual terhadap kedelapan node desktop, lalu lakukan QA mobile/tablet/keyboard/zoom.

## 17. Visual Acceptance Checklist

- [ ] Header kandidat, title, subtitle, back, complete, edit, dan cancel state sesuai sumber.
- [ ] Stepper memiliki current, complete, dan upcoming state yang benar.
- [ ] Main wrapper/card mengikuti baseline `1024px`/`960px` tanpa fixed width pada viewport kecil.
- [ ] Field standar `42px`, upload `48px`, radius `8px`, card radius `14px`.
- [ ] Step 1 dan 2 mengikuti urutan serta grid Figma.
- [ ] Step 3 memiliki SMA/SMK card dan perguruan tinggi optional/empty state.
- [ ] Step 4 Fresh Graduate dan Ada Pengalaman mempunyai conditional layout yang benar.
- [ ] Complete/read-only dan Edit Mode dapat dibedakan tanpa mengurangi keterbacaan.
- [ ] History locked, empty, dan loaded sesuai node `1:3385`, `1:3539`, dan `1:4482`.
- [ ] Status Menunggu memakai warning badge dan teks eksplisit.
- [ ] Error, loading, focus, disabled, upload, dan success state konsisten dengan token V2.
- [ ] Tidak ada URL asset Figma sementara atau dokumen user pada public storage.
- [ ] Responsive, accessibility, dan zoom 200% telah diverifikasi.

## 18. Definition of Done Visual

Versi 3 memenuhi desain ketika kedelapan frame memiliki padanan route/state yang jelas; page header, stepper, empat form step, complete/edit mode, dan tiga state riwayat konsisten dengan token TVIP; serta flow lamaran Versi 2 aktif tanpa menciptakan bahasa visual baru. Hasil akhir harus responsif, dapat dioperasikan keyboard, tetap terbaca pada zoom 200%, menggunakan private user content, dan tidak mempertahankan layout absolut dari hasil ekspor Figma.

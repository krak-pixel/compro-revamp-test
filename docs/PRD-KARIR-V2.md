# PRD — Website TVIP Versi 2: Sistem Karir

## 1. Ringkasan Proyek

**Nama Proyek:** Website TVIP Versi 2 — Sistem Karir  
**Jenis:** Pengembangan lanjutan website company profile menjadi portal lowongan dan lamaran kerja dinamis  
**Status Dokumen:** Scope Versi 2 disetujui untuk implementasi kandidat/public-first  
**Basis Implementasi:** Repository `krak-pixel/compro-revamp-test`, branch `main`  
**Desain Utama:** Figma file `yn2rF2dwEivl7pQow9EBXp` (`compro`)

**Tujuan:** Mengaktifkan menu Karir yang pada Versi 1 masih nonaktif, menyediakan informasi lowongan kerja yang dapat dicari dan difilter, serta memungkinkan kandidat membuat akun. Pengajuan lamaran online dilanjutkan pada Versi 3. Versi 2 harus menyatu dengan halaman Home Versi 1 dan mempertahankan identitas visual TVIP yang sudah diterapkan.

> **Prinsip pengembangan:** Versi 1 tetap menjadi fondasi untuk navbar, footer, token visual, komponen tombol/kartu, dan konfigurasi Laravel. Versi 2 menambahkan route serta modul Karir tanpa menggandakan komponen yang sudah tersedia.

### Keputusan Scope Implementasi — 10 September 2026

- Registrasi berhasil mengarahkan pengguna ke **login manual**; tidak ada auto-login.
- Versi 2 mencakup portal publik, pencarian/filter/pagination, poster modal, detail lowongan, autentikasi kandidat, dan state hero kandidat login.
- Drawer **Konfirmasi Lamaran** dan **Kirim CV** tersedia sebagai preview yang jujur, tetapi submit serta field yang bergantung pada profil dinonaktifkan dengan pemberitahuan Versi 3.
- Pelengkapan profil, pas foto, CV/portofolio, dan pengiriman lamaran/talent pool menjadi scope **Versi 3**.
- Panel dan workflow HR menjadi scope **Versi 4**.

Keputusan di atas mengesampingkan requirement lanjutan pada dokumen ini apabila requirement tersebut menyebut submission kandidat atau admin sebagai bagian Versi 2. Bagian tersebut dipertahankan sebagai backlog Versi 3/4.

## 2. Sumber Desain dan Pemetaan Frame

| Node Figma | Nama/State | Peran dalam Produk |
|---|---|---|
| `1:756` | Karir Page — Logout View | Halaman daftar lowongan untuk pengunjung yang belum login |
| `1:1153` | Karir Page — Login View | Halaman daftar lowongan untuk kandidat yang sudah login |
| `1:105` | Login Page | Autentikasi kandidat sebelum mengajukan lamaran |
| `1:152` | Register Page | Pendaftaran akun kandidat |
| `1:1563` | Poster View | Modal preview poster lowongan |
| `1:1974` | Sheet: Detail Lowongan | Drawer detail posisi, deskripsi pekerjaan, dan kualifikasi |
| `1:2457` | Sheet: Lamar | Drawer konfirmasi sebelum mengirim lamaran untuk posisi tertentu |
| `1:2936` | Sheet: Kirim CV Sekarang | Drawer pengiriman CV untuk kandidat yang belum menemukan posisi sesuai |

Seluruh ukuran, hierarchy, warna, copy, komponen, overlay, dan state visual pada node di atas menjadi acuan implementasi desktop. Desain mobile spesifik belum tersedia pada node yang diberikan; perilaku mobile mengikuti requirement responsif pada Section 12 dan harus divalidasi secara terpisah.

## 3. Hubungan Versi 1 dan Versi 2

### 3.1 Fitur Versi 1 yang Dipertahankan

- Halaman Home pada route `/`.
- Section `#home`, `#tentang-kami`, dan `#kontak-kami`.
- Navbar, footer, modal kontak, dan identitas visual TVIP.
- Form kontak beserta penyimpanan pesan dan notifikasi email.
- Komponen Blade, Tailwind CSS, Alpine.js, serta aset visual yang sudah tersedia.

### 3.2 Perubahan pada Versi 2

- Menu **Karir** di navbar dan footer diaktifkan.
- Route `/karir` ditambahkan sebagai halaman portal karir.
- Autentikasi kandidat ditambahkan melalui login dan registrasi.
- Data lowongan menjadi dinamis dari database.
- Kandidat dapat melihat poster, membaca detail, membuat akun, login, dan membuka preview langkah lamaran.
- Pengiriman CV/lamaran disiapkan untuk Versi 3; panel HR disiapkan untuk Versi 4.

## 4. Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13 / PHP 8.3 |
| Templating | Blade |
| Styling | Tailwind CSS |
| Interaktivitas | Alpine.js |
| Database | MySQL; SQLite in-memory untuk automated test |
| Authentication | Laravel session authentication |
| Admin Panel | Direncanakan untuk Versi 4 |
| File Storage | Private document storage direncanakan untuk Versi 3 |
| Email | Laravel Mail/Queue |
| Build Tool | Vite |
| Testing | PHPUnit Feature Test dan browser/E2E test bila tersedia |

## 5. Target Pengguna

1. **Pengunjung/Guest** — melihat, mencari, memfilter, dan membaca lowongan tanpa harus membuat akun.
2. **Kandidat Terdaftar** — login dan melihat preview langkah lamaran; submission tersedia pada Versi 3.
3. **Admin/HR TVIP** — target pengguna Versi 4, bukan scope implementasi Versi 2.

## 6. Sitemap dan Routing

```text
/                              → Home Versi 1
├─ #tentang-kami               → Section Tentang Kami
└─ #kontak-kami                → Section Kontak Kami

/karir                         → Daftar lowongan
/karir/login                   → Login kandidat
/karir/register                → Registrasi kandidat
/karir/{slug}                  → Detail lowongan dalam state drawer
/karir/{slug}/apply            → Preview konfirmasi lamaran; submit V3
/karir/kirim-cv                → Preview pengiriman CV umum; submit V3
/karir/profile                 → Direncanakan untuk V3

/admin                         → Direncanakan untuk V4
```

Route detail tetap memiliki URL berbasis slug agar lowongan dapat dibagikan, diindeks, dan dibuka ulang secara langsung. Presentasi visualnya mengikuti drawer Figma. Preview poster dapat menggunakan modal di halaman yang sama dan tidak wajib memiliki canonical URL terpisah.

## 7. User Flow

### 7.1 Guest Mencari Lowongan

1. Pengunjung membuka `/karir`.
2. Sistem menampilkan hero Karir, statistik, search, filter, daftar lowongan aktif, pagination, CTA kirim CV, dan footer.
3. Pengunjung dapat mencari berdasarkan nama posisi atau kualifikasi.
4. Pengunjung dapat memfilter berdasarkan departemen, posisi, dan lokasi.
5. Pengunjung dapat membuka poster atau detail lowongan tanpa login.
6. Saat memilih **Lamar**, guest diarahkan ke login dengan intended URL tersimpan.
7. Guest dapat login atau membuat akun.
8. Setelah berhasil, pengguna dikembalikan ke posisi yang dipilih dan melihat konfirmasi lamaran.

### 7.2 Kandidat Login Melamar Posisi

1. Kandidat membuka detail atau menekan tombol **Lamar** pada job card.
2. Sistem menampilkan drawer **Konfirmasi Lamaran**.
3. Kandidat memeriksa departemen, lokasi, jenis pekerjaan, deskripsi, dan kualifikasi.
4. Pada Versi 2, tombol submit dinonaktifkan dan drawer menjelaskan bahwa profil, CV, serta pengiriman lamaran tersedia pada Versi 3.
5. Validasi kelengkapan, pencegahan duplikasi, dan penyimpanan lamaran diterapkan pada Versi 3.

### 7.3 Kandidat Mengirim CV Umum

1. Kandidat memilih **Kirim CV Sekarang** pada banner ketika belum menemukan posisi sesuai.
2. Jika belum login, sistem mengarahkan kandidat ke login/registrasi dan menyimpan intended action.
3. Sistem menampilkan preview data kandidat yang tersedia dari akun.
4. Pada Versi 2, pemilihan minat dan submit dinonaktifkan dengan pemberitahuan Versi 3.
5. Penyimpanan talent pool/general application diterapkan pada Versi 3.

## 8. Functional Requirements

### 8.1 Navbar dan Navigasi

- Navbar Karir menggunakan logo dan menu yang sama dengan Versi 1.
- Menu **Karir** aktif dan menampilkan underline biru sesuai desain.
- Link Home, Tentang Kami, dan Kontak Kami dari halaman Karir menuju route `/` beserta anchor yang sesuai.
- Pada state guest, hero menampilkan tombol **Login** dan **Daftar**.
- Pada state login, hero menampilkan nama, email, avatar/profile icon, dan aksi **Logout**.
- Logout harus menggunakan request `POST`, mengakhiri session, dan kembali ke halaman Karir.

### 8.2 Hero Karir

- Menampilkan badge **We Are Hiring!**.
- Headline: **Bergabunglah dengan Tim TVIP**.
- Deskripsi: “Jadilah bagian dari perusahaan distribusi & logistik terkemuka di Indonesia. Temukan kesempatan karir terbaik Anda bersama TVIP GROUP.”
- Statistik menampilkan jumlah lowongan aktif, kota, dan departemen.
- Angka statistik diambil dari database dan tidak di-hardcode.
- Latar menggunakan bidang biru TVIP dengan bentuk gelombang bawah sesuai Figma.

### 8.3 Pencarian dan Filter

- Search menerima kata kunci posisi atau kualifikasi.
- Placeholder: **Cari posisi, kualifikasi…**.
- Filter tersedia untuk departemen, posisi, dan lokasi.
- Default filter: **Semua Departemen**, **Semua Posisi**, dan **Semua Lokasi**.
- Filter posisi menyesuaikan departemen terpilih jika relasi tersebut diterapkan di database.
- Kata kunci, filter, dan halaman disimpan pada URL query parameter agar hasil dapat dibagikan dan dipulihkan setelah navigasi.
- Perubahan filter mengembalikan pagination ke halaman pertama.
- Search harus memiliki tombol clear ketika berisi teks.
- Sistem menampilkan jumlah hasil dan indikator halaman, misalnya “Menampilkan 12 lowongan” dan “Halaman 1 / 2”.

### 8.4 Daftar dan Job Card

- Desktop menggunakan grid tiga kolom sesuai desain.
- Setiap job card menampilkan:
  - poster/gambar lowongan;
  - kategori/departemen;
  - level/posisi;
  - nama lowongan;
  - lokasi;
  - jenis pekerjaan;
  - periode buka dan tutup;
  - tombol **Lamar**.
- Poster dapat dibuka dalam modal **Poster View**.
- Informasi detail lowongan dapat dibuka melalui drawer.
- Daftar hanya menampilkan lowongan berstatus published, aktif, dan berada dalam periode tayang.
- Pagination menampilkan enam kartu per halaman pada desktop sesuai frame contoh.
- Sistem menyediakan state loading, kosong, tidak ditemukan, dan gagal memuat.

### 8.5 Poster View

- Poster tampil di tengah viewport dengan overlay gelap.
- Poster menggunakan aset asli milik lowongan dan mempertahankan aspect ratio.
- Modal memiliki tombol tutup, dapat ditutup dengan `Escape`, dan dapat ditutup melalui overlay.
- Fokus keyboard masuk ke modal saat dibuka, terperangkap selama modal aktif, dan kembali ke trigger ketika ditutup.
- Background tidak dapat di-scroll atau difokuskan saat modal aktif.

### 8.6 Detail Lowongan

- Detail ditampilkan sebagai drawer dari sisi kanan.
- Bagian atas menampilkan potongan poster lowongan dan tombol tutup.
- Isi mencakup:
  - nama posisi;
  - departemen;
  - lokasi;
  - jenis pekerjaan;
  - deskripsi pekerjaan;
  - daftar kualifikasi.
- Konten drawer dapat di-scroll tanpa menggeser halaman di belakang.
- URL detail menggunakan `/karir/{slug}` dan kembali ke daftar saat drawer ditutup.
- Direct visit ke URL slug harus tetap menampilkan halaman Karir dengan drawer detail terbuka.

### 8.7 Login Kandidat

- Halaman mengikuti node `1:105` dengan layout kartu putih di atas background biru TVIP.
- Field wajib: email dan password.
- CTA utama secara fungsional menggunakan label **Masuk**. Label “Lamar” pada frame diperlakukan sebagai inkonsistensi copy dan perlu diselaraskan sebelum implementasi final.
- Tersedia link kembali ke halaman Karir dan link menuju registrasi.
- Setelah login berhasil, kandidat diarahkan ke intended URL atau `/karir`.
- Error autentikasi ditampilkan secara inline tanpa menghapus nilai email.
- Session diregenerasi setelah login berhasil.

### 8.8 Registrasi Kandidat

- Halaman mengikuti node `1:152`.
- Field:
  - nama lengkap, opsional sesuai desain;
  - email, wajib dan unik;
  - password, wajib minimal enam karakter sesuai copy desain;
  - konfirmasi password, wajib dan harus sama.
- CTA utama secara fungsional menggunakan label **Daftar**. Label “Lamar” pada frame diperlakukan sebagai inkonsistensi copy.
- Setelah registrasi berhasil, kandidat login otomatis atau diarahkan ke login sesuai keputusan implementasi yang ditetapkan.
- Kandidat diarahkan ke intended URL setelah autentikasi selesai.
- Persetujuan syarat dan ketentuan harus memiliki link yang dapat dibuka; teks informatif saja tidak menggantikan kebijakan privasi yang valid.

### 8.9 Konfirmasi Lamaran Spesifik

**Scope Versi 2:** shell dan informasi drawer diimplementasikan sebagai preview; submit dinonaktifkan. Requirement penyimpanan di bawah menjadi backlog Versi 3.

- Drawer mengikuti node `1:2457`.
- Menampilkan nama posisi, metadata lowongan, deskripsi, dan kualifikasi.
- Tombol tersedia: **Batal** dan **Lamar Sekarang**.
- Tombol submit hanya aktif jika pengguna login, profil minimum lengkap, CV tersedia, dan lowongan masih aktif.
- Sistem mencegah double-click/double submission.
- Satu kandidat tidak dapat mengirim lamaran aktif berulang untuk lowongan yang sama.
- Keberhasilan dan kegagalan harus diberikan melalui feedback yang dapat dibaca screen reader.

### 8.10 Kirim CV Sekarang / Talent Pool

**Scope Versi 2:** candidate preview dan struktur drawer diimplementasikan; seluruh field yang membutuhkan profil serta aksi submit dinonaktifkan. Requirement penyimpanan menjadi backlog Versi 3.

- Drawer mengikuti node `1:2936`.
- Menampilkan preview data kandidat: nama, email, avatar/pas foto, nomor telepon, tempat tinggal, status pengalaman, dan pendidikan.
- Kandidat memilih departemen, posisi, dan lokasi yang diminati.
- Ketiga pilihan wajib diisi sebelum submit.
- Tombol **Lamar Sekarang** disabled sampai seluruh input wajib valid.
- Submission disimpan sebagai general application/talent pool.
- Data CV yang dikirim harus berasal dari profil kandidat atau kandidat diminta melengkapinya sebelum submit.

### 8.11 Profil Kandidat dan Dokumen

**Milestone:** Versi 3.

Requirement ini diperlukan oleh flow lamaran, tetapi frame UI-nya belum termasuk dalam delapan node yang diberikan.

- Profil minimum harus mendukung nama, email, nomor telepon, domisili, status pengalaman, pendidikan, pas foto opsional, CV wajib, dan portofolio opsional.
- Kandidat dapat memperbarui profil dan mengganti CV.
- CV serta dokumen pribadi disimpan pada private storage dan tidak boleh menggunakan URL publik permanen.
- Admin hanya dapat mengakses dokumen sesuai kewenangan HR.
- Sebelum implementasi, perlu diputuskan apakah pengisian profil dilakukan pada halaman tersendiri atau sebagai step tambahan setelah registrasi.

### 8.12 Admin/HR

**Milestone:** Versi 4.

- Admin panel berada di `/admin` dan dilindungi autentikasi admin.
- HR dapat mengelola departemen, posisi, lokasi, dan lowongan.
- HR dapat membuat draft, memublikasikan, menutup, dan mengarsipkan lowongan.
- HR dapat mengunggah poster lowongan serta mengatur periode tayang.
- HR dapat melihat lamaran spesifik dan talent pool.
- HR dapat mengubah status lamaran sesuai workflow yang disetujui.
- Perubahan status, akses dokumen, ekspor kandidat, dan penghapusan data harus mengikuti kebijakan akses dan retensi yang ditetapkan TVIP.

## 9. Data Model Minimum

### 9.1 `users`

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `name` | Nullable sesuai desain registrasi |
| `email` | Unique, required |
| `password` | Hashed |
| `email_verified_at` | Nullable |
| timestamps | Required |

### 9.2 `candidate_profiles`

> Direncanakan untuk Versi 3; tabel tidak dibuat pada Versi 2.

| Field | Tipe/Aturan |
|---|---|
| `user_id` | Unique foreign key |
| `phone` | Required sebelum melamar |
| `residence` | Required sebelum melamar |
| `experience_status` | Required sebelum melamar |
| `education_level` | Required sebelum melamar |
| `photo_path` | Nullable, private |
| `cv_path` | Required sebelum melamar, private |
| `portfolio_path` | Nullable, private |
| timestamps | Required |

### 9.3 `departments`

- `id`, `name`, `slug`, `is_active`, timestamps.

### 9.4 `positions`

- `id`, `department_id`, `name`, `slug`, `level`, `is_active`, timestamps.

### 9.5 `locations`

- `id`, `name`, `slug`, `is_active`, timestamps.

### 9.6 `jobs`

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `department_id` | Foreign key |
| `position_id` | Foreign key |
| `location_id` | Foreign key |
| `title` | Required |
| `slug` | Unique |
| `employment_type` | Required, contoh `full_time` |
| `description` | Required |
| `qualifications` | JSON atau relasi child |
| `poster_path` | Required sesuai desain |
| `opens_at` | Required |
| `closes_at` | Required |
| `status` | `draft`, `published`, `closed`, `archived` |
| `published_at` | Nullable |
| timestamps | Required |

### 9.7 `applications`

> Direncanakan untuk Versi 3; tabel tidak dibuat pada Versi 2.

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `user_id` | Foreign key kandidat |
| `job_id` | Nullable untuk talent pool |
| `department_id` | Required untuk talent pool atau snapshot |
| `position_id` | Required untuk talent pool atau snapshot |
| `location_id` | Required untuk talent pool atau snapshot |
| `candidate_snapshot` | JSON snapshot data kandidat saat melamar |
| `cv_path_snapshot` | Referensi versi CV yang dikirim |
| `type` | `job_application` atau `talent_pool` |
| `status` | Status workflow HR yang disetujui |
| `submitted_at` | Required |
| timestamps | Required |

Database harus menetapkan constraint untuk mencegah lamaran ganda pada kombinasi kandidat dan lowongan sesuai business rule.

## 10. Business Rules

1. Guest dapat membaca semua lowongan publik tanpa login.
2. Login hanya diwajibkan ketika kandidat mengirim lamaran atau CV umum.
3. Lowongan tampil jika berstatus `published`, sudah mencapai tanggal buka, dan belum melewati tanggal tutup.
4. Data periode tahun 2025 pada mockup adalah contoh konten dan tidak boleh di-hardcode.
5. Statistik hero dihitung dari data published aktif.
6. Satu kandidat hanya dapat memiliki satu lamaran aktif per lowongan.
7. Lamaran menyimpan snapshot data kandidat dan versi CV saat submission agar perubahan profil berikutnya tidak mengubah arsip lamaran lama.
8. Talent pool tidak disamakan dengan lamaran pada lowongan aktif.
9. Penutupan lowongan tidak menghapus lamaran yang sudah masuk.
10. Akses kandidat, HR, dokumen, dan perubahan status harus diperiksa di server; UI bukan satu-satunya lapisan otorisasi.

## 11. State dan Error Handling

### 11.1 Daftar Lowongan

- **Loading:** ruang grid dipertahankan agar layout tidak meloncat.
- **Empty:** belum ada lowongan aktif; CTA Kirim CV tetap tersedia.
- **No results:** tidak ada hasil sesuai search/filter; tersedia aksi reset filter.
- **Error:** pesan gagal memuat dengan tombol coba lagi.
- **Expired:** detail tidak menerima lamaran baru dan menjelaskan bahwa periode telah berakhir.

### 11.2 Authentication

- Kredensial salah.
- Email sudah terdaftar.
- Konfirmasi password tidak sama.
- Session kedaluwarsa saat membuka drawer atau submit.
- Intended URL dipertahankan setelah login/registrasi.

### 11.3 Lamaran

- Profil belum lengkap.
- CV belum tersedia atau tidak lagi valid.
- Lowongan ditutup saat drawer masih terbuka.
- Lamaran duplikat.
- Upload atau penyimpanan gagal.
- Email notifikasi gagal tetapi data lamaran sudah tersimpan.
- Submit berhasil dengan feedback yang jelas dan idempotent.

## 12. Non-Functional Requirements

### 12.1 Responsif

- Mobile: `< 640px`.
- Tablet: `640–1024px`.
- Desktop: `> 1024px`.
- Grid job card berubah dari tiga kolom menjadi dua dan satu kolom sesuai ruang tersedia.
- Drawer desktop berubah menjadi panel layar penuh atau bottom sheet yang tetap dapat dioperasikan pada mobile.
- Modal poster tidak melebihi viewport dan poster tetap mempertahankan aspect ratio.
- Seluruh target sentuh utama minimal 44 × 44 px.

### 12.2 Performa

- Target PageSpeed minimal 90 untuk mobile dan desktop pada halaman publik.
- Poster dan foto menggunakan WebP/AVIF jika memungkinkan, responsive `srcset`, dimensi eksplisit, dan lazy loading di bawah fold.
- Query list menggunakan eager loading untuk relasi departemen, posisi, dan lokasi.
- Pagination dilakukan di server.
- Search/filter diberi debounce sekitar 300 ms jika menggunakan request asynchronous.
- Email notifikasi dikirim melalui queue agar submit tidak menunggu SMTP.

### 12.3 Aksesibilitas

- Target WCAG 2.2 AA.
- Semua form menggunakan label yang terasosiasi.
- Error memiliki `aria-invalid` dan `aria-describedby`.
- Fokus keyboard terlihat dan tidak tertutup navbar/drawer.
- Modal/drawer memiliki accessible name, description, focus trap, `Escape`, inert background, dan focus restoration.
- Informasi tidak disampaikan melalui warna saja.
- Reduced-motion preference dihormati.

### 12.4 Keamanan dan Privasi

- CSRF protection, rate limiting, validasi server, dan sanitasi input wajib.
- Password selalu di-hash dan tidak pernah dicatat ke log.
- CV, pas foto, dan portofolio menggunakan private storage.
- Upload dibatasi berdasarkan MIME sebenarnya, ukuran, dan ekstensi yang disetujui.
- Nama file pengguna tidak digunakan langsung sebagai nama penyimpanan.
- Download dokumen menggunakan authorized controller atau temporary URL.
- Data sensitif tidak dimasukkan ke query string, analytics, toast, atau log aplikasi.
- Kebijakan privasi, persetujuan pemrosesan data, masa retensi, penghapusan, dan hak akses HR harus ditetapkan TVIP sebelum production release.

### 12.5 SEO

- `/karir` memiliki title dan meta description unik.
- Setiap `/karir/{slug}` memiliki metadata lowongan unik serta canonical URL.
- Structured data `JobPosting` digunakan untuk lowongan yang aktif.
- Lowongan expired tidak lagi memakai `validThrough` aktif dan diarahkan sesuai kebijakan arsip.
- Sitemap memuat halaman Karir serta lowongan aktif.

## 13. Acceptance Criteria

### 13.1 Integrasi Versi 1 dan Versi 2

- [ ] Halaman Home Versi 1 tetap berfungsi tanpa regresi visual atau fungsional.
- [ ] Menu Karir aktif pada navbar dan footer.
- [ ] Navigasi dari Karir ke anchor Home bekerja dengan benar.
- [ ] Token visual dan komponen bersama digunakan kembali.

### 13.2 Karir Publik

- [ ] `/karir` dapat diakses guest dan kandidat login.
- [ ] State header guest dan login sesuai node `1:756` dan `1:1153`.
- [ ] Search, tiga filter, result count, dan pagination bekerja bersama.
- [ ] Query/filter/page dapat dipulihkan dari URL.
- [ ] Poster modal sesuai node `1:1563`.
- [ ] Detail drawer sesuai node `1:1974` dan dapat dibuka melalui URL slug.

### 13.3 Authentication

- [ ] Login dan registrasi mengikuti node `1:105` dan `1:152`.
- [ ] Validasi dan error ditampilkan inline.
- [ ] Intended destination dipulihkan setelah autentikasi.
- [ ] Logout menghapus session melalui request POST.

### 13.4 Submission

> Acceptance criteria bagian ini berlaku untuk Versi 3. Versi 2 hanya wajib menampilkan preview disabled dan pemberitahuan scope.

- [ ] Guest diarahkan login sebelum submit.
- [ ] Kandidat melihat konfirmasi sesuai node `1:2457`.
- [ ] Lamaran ganda dicegah pada server dan database.
- [ ] Tombol submit mempunyai state idle, loading, success, dan failure tanpa perubahan ukuran.
- [ ] Flow Kirim CV mengikuti node `1:2936` dan disimpan sebagai talent pool.
- [ ] Dokumen kandidat tidak dapat diakses secara publik tanpa otorisasi.

### 13.5 Quality Gate

- [ ] Feature test V2 mencakup list/filter/detail, login, register, protected preview, expired job, dan sitemap. Duplicate apply, talent pool, file authorization, serta submission rate limit menjadi quality gate V3.
- [ ] Production asset build berhasil.
- [ ] Keyboard navigation, focus trap, Escape, dan focus restoration diverifikasi.
- [ ] Tampilan diuji pada mobile, tablet, desktop, serta zoom 200%.
- [ ] Tidak ada placeholder link atau credential contoh pada production.

## 14. Admin/HR Acceptance Criteria

> Seluruh acceptance criteria bagian ini berlaku untuk Versi 4.

- [ ] Hanya admin/HR terotorisasi yang dapat mengakses admin panel.
- [ ] HR dapat membuat, mengedit, memublikasikan, menutup, dan mengarsipkan lowongan.
- [ ] Poster, deskripsi, kualifikasi, lokasi, departemen, jenis kerja, dan periode dapat dikelola.
- [ ] HR dapat melihat lamaran per lowongan dan talent pool.
- [ ] HR dapat mengunduh dokumen melalui akses yang terotorisasi.
- [ ] Perubahan status dan akses dokumen dapat diaudit sesuai kebijakan yang disetujui.

## 15. Out of Scope Versi 2

- Pelengkapan profil kandidat, pas foto, CV, dan portofolio.
- Penyimpanan lamaran spesifik dan talent pool.
- Panel admin serta workflow HR.
- Integrasi job board eksternal.
- Login kandidat melalui Google, LinkedIn, atau provider sosial lain.
- Penjadwalan interview otomatis.
- Video interview dan assessment online.
- Notifikasi WhatsApp/SMS.
- Multi-language.
- Employee referral system.
- Applicant tracking system kompleks di luar workflow status dasar HR.

## 16. Keputusan Produk

### 16.1 Sudah Ditetapkan untuk Versi 2

1. Registrasi dilanjutkan dengan login manual.
2. Portal kandidat/public dikerjakan lebih dahulu.
3. Profil, upload CV, dan submission ditunda ke Versi 3.
4. Panel HR ditunda ke Versi 4.
5. Copy aksi auth menggunakan **Masuk** dan **Daftar**, bukan “Lamar”.

### 16.2 Masih Diperlukan untuk Versi 3/4

1. **Profil kandidat:** tidak ada frame pengisian nomor telepon, domisili, pengalaman, pendidikan, pas foto, CV, dan portofolio, tetapi data tersebut digunakan di node `1:2936`. Diperlukan desain/keputusan tentang halaman atau step pengisian profil.
2. **Upload CV:** format yang diterima, batas ukuran, kewajiban portofolio, serta masa retensi belum ditentukan.
3. **State sukses:** belum ada frame sukses untuk lamaran spesifik maupun talent pool.
4. **Workflow status HR:** daftar status kandidat, aturan transisi, notifikasi, dan hak akses belum ditentukan.
5. **Verifikasi email:** perlu diputuskan apakah kandidat wajib memverifikasi email sebelum melamar.
6. **Consent dan retensi:** teks persetujuan, kebijakan privasi, durasi penyimpanan data kandidat, dan mekanisme penghapusan harus ditetapkan oleh TVIP.
7. **Avatar/pas foto:** perlu diputuskan apakah wajib, opsional, atau hanya menggunakan placeholder.

Keputusan pada poin 1, 2, 5, dan 7 memengaruhi data pribadi dan workflow utama sehingga tidak boleh ditetapkan melalui asumsi implementasi.

## 17. Milestone Implementasi

### Milestone 1 — Fondasi dan Integrasi

- Sinkronisasi route serta navbar Versi 1.
- Penyiapan komponen layout Karir dan design token bersama.
- Database departemen, posisi, lokasi, dan lowongan.

### Milestone 2 — Portal Karir Publik

- Hero, search, filter, job card, pagination, empty/error state.
- Poster modal dan detail drawer.
- SEO halaman Karir dan JobPosting structured data.

### Milestone 3 — Versi 3: Profil dan Submission

- Profil kandidat dan private document upload setelah keputusan Section 16 diselesaikan.
- Konfirmasi serta pengiriman lamaran spesifik dan talent pool.
- Duplicate prevention, feedback, queue notification, dan audit data.

### Milestone 4 — Versi 4: Admin HR

- Filament resources untuk master data, lowongan, dan lamaran.
- Role/permission, authorized document access, dan status workflow.

### Milestone 5 — QA dan Release per Versi

- Automated test, browser test, accessibility, responsive, security, dan performance audit.
- UAT bersama HR.
- Perbaikan akhir dan deployment production.

## 18. Definition of Done

Versi 2 dinyatakan selesai ketika Home Versi 1 tidak mengalami regresi, katalog lowongan publik dan autentikasi kandidat berfungsi, preview drawer menyatakan batas scope V3 secara jujur, route publik/protected teruji, serta hasil akhir dibandingkan ulang dengan delapan node Figma sumber. Penyimpanan data kandidat selain akun, submission, dan admin HR tidak menjadi syarat selesai Versi 2.

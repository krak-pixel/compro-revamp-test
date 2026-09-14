# PRD — Website TVIP Versi 3: Profil Kandidat dan Lamaran

## 1. Ringkasan Proyek

**Nama Proyek:** Website TVIP Versi 3 — Profil Kandidat dan Pengiriman Lamaran  
**Jenis:** Pengembangan lanjutan portal Karir TVIP dari katalog lowongan menjadi portal kandidat transaksional  
**Status Dokumen:** Acuan pra-implementasi; siap untuk technical refinement dan persetujuan product owner/HR  
**Basis Implementasi:** Repository `krak-pixel/compro-revamp-test`, setelah Versi 2 digabungkan ke branch `main`  
**Branch Implementasi yang Disarankan:** `feature/career-v3`  
**Desain Utama:** Figma file `yn2rF2dwEivl7pQow9EBXp` (`compro`)  
**Tanggal Acuan:** 12 September 2026

**Tujuan:** Mengaktifkan fungsi yang pada Versi 2 masih berupa preview, yaitu pengisian profil kandidat, upload dokumen, pengiriman lamaran ke lowongan tertentu, pengiriman CV umum/talent pool, serta riwayat lamaran kandidat. Versi 3 harus mempertahankan halaman Home Versi 1 dan katalog Karir Versi 2 tanpa regresi.

> **Prinsip pengembangan:** Versi 3 memperluas autentikasi dan drawer lamaran Versi 2. Navbar, footer, katalog lowongan, auth, design token, dan primitive overlay/drawer yang sudah ada wajib digunakan kembali. Panel operasional HR tetap menjadi scope Versi 4.

### Keputusan Scope Versi 3

- Kandidat tetap melakukan login manual setelah registrasi sebagaimana keputusan Versi 2.
- Kandidat harus menyelesaikan wizard profil empat langkah sebelum mengirim lamaran.
- Wizard mencakup Data Induk, Data Detail, Data Pendidikan, dan Data Pengalaman.
- Pas foto, CV, ijazah, dan paklaring disimpan pada private storage.
- Lamaran spesifik dan CV umum/talent pool mulai disimpan pada database.
- Kandidat dapat melihat riwayat lamaran miliknya sendiri.
- Status awal yang terlihat kandidat adalah **Menunggu**; pengelolaan status oleh HR tersedia pada Versi 4.
- Panel HR, CRUD lowongan oleh HR, seleksi, interview, dan keputusan penerimaan tidak termasuk Versi 3.
- Field berisiko tinggi dari desain Figma memerlukan persetujuan kebutuhan bisnis dan review privasi sebelum production release.

## 2. Sumber Desain dan Pemetaan Frame

| Node Figma | Nama/State | Peran dalam Produk |
|---|---|---|
| `1:3385` | Form Kandidat Page: Data Induk | Wizard step 1 dalam kondisi awal/belum lengkap |
| `1:3849` | Form Kandidat Page: Data Detail | Wizard step 2 untuk kontak dan alamat |
| `1:3973` | Form Kandidat Page: Data Pendidikan | Wizard step 3 untuk SMA/SMK dan perguruan tinggi |
| `1:4107` | Data Pengalaman — Fresh Graduate | Wizard step 4 tanpa riwayat kerja |
| `1:4205` | Data Pengalaman — Ada Pengalaman | Wizard step 4 dengan form pengalaman kerja |
| `1:3539` | Formulir Lengkap | Profil tersimpan, read-only, belum ada lamaran |
| `1:3698` | Edit Mode | Profil lengkap dalam mode perubahan data |
| `1:4482` | Riwayat Lamaran | Profil lengkap dengan satu atau lebih lamaran |

Seluruh frame memiliki baseline desktop selebar `1482px`. Desain mobile/tablet tidak disediakan sebagai frame terpisah; perilaku responsif pada Section 13 merupakan requirement implementasi.

Versi 3 juga menggunakan kembali frame Versi 2 berikut:

| Node V2 | Pemakaian pada V3 |
|---|---|
| `1:2457` | Drawer konfirmasi lamaran yang submit-nya diaktifkan |
| `1:2936` | Drawer Kirim CV Sekarang/talent pool yang submit-nya diaktifkan |
| `1:1974` | Drawer detail lowongan sebelum kandidat melamar |
| `1:756` dan `1:1153` | Katalog Karir guest dan kandidat login |

Tidak terdapat frame khusus untuk state submit loading, submit gagal, lamaran berhasil, upload gagal, atau duplicate application. State tersebut tetap wajib dibuat menggunakan design system dan pola feedback Versi 2.

## 3. Hubungan Versi 1, Versi 2, Versi 3, dan Versi 4

### 3.1 Fondasi yang Dipertahankan

- Home, Tentang Kami, Kontak Kami, navbar, footer, dan modal kontak dari Versi 1.
- Katalog lowongan, filter, pagination, poster modal, detail drawer, login, register, dan logout dari Versi 2.
- Model `User`, `Job`, `Department`, `Position`, dan `Location` dari Versi 2.
- Blade, Tailwind CSS, Alpine.js, Laravel session authentication, MySQL, dan Vite.
- URL lowongan berbasis slug dan intended URL setelah login.

### 3.2 Perubahan pada Versi 3

- State kandidat login pada hero memperoleh akses menuju Form Kandidat.
- Notice “tersedia pada Versi 3” di drawer lamaran diganti dengan flow nyata.
- Data kandidat disimpan secara terstruktur dan dapat diperbarui.
- Dokumen kandidat diunggah ke private storage.
- Lamaran spesifik dan talent pool disimpan ke database.
- Kandidat dapat melihat riwayat lamaran sendiri.

### 3.3 Batas Versi 4

- HR/admin mengelola master data dan lowongan.
- HR melihat kandidat, membuka dokumen, dan memproses status lamaran.
- Audit akses dokumen, role/permission, ekspor, komunikasi kandidat, serta workflow interview tersedia di Versi 4.

## 4. Tech Stack dan Batas Teknis

| Layer | Teknologi/Keputusan |
|---|---|
| Backend | Laravel 13 / PHP 8.3 |
| Templating | Blade components |
| Styling | Tailwind CSS 3.4 dan token TVIP yang sudah ada |
| Interaktivitas | Alpine.js 3.14 untuk progressive enhancement |
| Database | MySQL; SQLite in-memory untuk automated test |
| Authentication | Laravel session authentication dari Versi 2 |
| File Storage | Laravel private/local disk; object storage private dapat digunakan saat production |
| Build Tool | Vite 7 |
| Testing | PHPUnit 12 Feature Test; browser/E2E bila tersedia |
| Admin Panel | Tidak diimplementasikan sampai Versi 4 |

Tidak diperbolehkan mengganti stack menjadi SPA/React hanya karena Figma MCP menghasilkan reference code React. Hasil Figma harus diterjemahkan ke Blade, Tailwind, dan Alpine yang sudah digunakan repository.

## 5. Target Pengguna dan Hak Akses

1. **Guest** — melihat katalog dan detail lowongan; diarahkan ke login saat melamar.
2. **Kandidat belum lengkap** — mengisi wizard profil dan belum dapat submit lamaran.
3. **Kandidat lengkap** — dapat mengirim lamaran, talent pool, melihat, dan memperbarui profil serta riwayatnya sendiri.
4. **HR/Admin** — penerima data pada fase berikutnya; tidak memiliki UI operasional pada Versi 3.

| Aksi | Guest | Kandidat Belum Lengkap | Kandidat Lengkap |
|---|:---:|:---:|:---:|
| Melihat lowongan | Ya | Ya | Ya |
| Membuka detail lowongan | Ya | Ya | Ya |
| Membuka Form Kandidat | Tidak | Ya | Ya |
| Upload dokumen | Tidak | Ya | Ya |
| Submit lamaran | Tidak | Tidak | Ya |
| Melihat riwayat sendiri | Tidak | Setelah profil tersimpan | Ya |
| Melihat lamaran kandidat lain | Tidak | Tidak | Tidak |

## 6. Sitemap dan Routing Target

```text
/karir                                  → Katalog Karir Versi 2
/karir/login                            → Login kandidat Versi 2
/karir/register                         → Registrasi kandidat Versi 2
/karir/profile                          → Form Kandidat / ringkasan profil
/karir/profile/steps/{step}             → Navigasi wizard step 1–4
/karir/profile/steps/{step} [PUT]       → Simpan draft step aktif
/karir/profile/complete [POST]          → Finalisasi profil setelah step 4 valid
/karir/documents/{document}             → Preview/download dokumen terotorisasi
/karir/{slug}                           → Detail lowongan Versi 2
/karir/{slug}/apply                     → Konfirmasi lamaran Versi 2/V3
/karir/{slug}/apply [POST]              → Kirim lamaran spesifik
/karir/kirim-cv                         → Form talent pool Versi 2/V3
/karir/kirim-cv [POST]                  → Kirim talent pool
```

Nama route yang disarankan:

- `career.profile.show`
- `career.profile.steps.show`
- `career.profile.steps.update`
- `career.profile.complete`
- `career.documents.show`
- `career.apply`
- `career.apply.store`
- `career.send-cv`
- `career.send-cv.store`

Seluruh route profil, dokumen, dan submit wajib memakai middleware `auth`. Download dokumen juga wajib melewati policy/authorization, bukan URL file publik.

## 7. User Flow

### 7.1 Melengkapi Profil dari Halaman Karir

1. Kandidat login membuka halaman Karir.
2. Kandidat memilih akses profil atau menekan **Lamar**.
3. Jika profil belum lengkap, sistem mengarahkan ke `/karir/profile` dan menyimpan intended action.
4. Kandidat mengisi step 1 sampai 4.
5. Setiap step divalidasi dan disimpan sebagai draft sebelum berpindah.
6. Pada step 4, kandidat memilih Fresh Graduate atau Ada Pengalaman.
7. Kandidat menekan **Simpan Formulir**.
8. Sistem menghitung ulang kelengkapan profil di server.
9. Jika lengkap, sistem menampilkan state **Formulir Lengkap**.
10. Jika terdapat intended action, kandidat dapat kembali ke konfirmasi lamaran yang sebelumnya dipilih.

### 7.2 Mengedit Profil

1. Kandidat dengan profil lengkap membuka `/karir/profile`.
2. Form tampil read-only dengan badge **Formulir Lengkap** dan tombol **Edit Form**.
3. Kandidat menekan **Edit Form**.
4. Sistem masuk ke state node `1:3698` dan menampilkan aksi **Batal Edit**.
5. Perubahan disimpan per step atau pada finalisasi sesuai strategi controller.
6. **Batal Edit** membuang perubahan yang belum disimpan, bukan menghapus profil tersimpan.
7. Perubahan profil tidak mengubah snapshot lamaran yang sudah dikirim.

### 7.3 Melamar Lowongan Spesifik

1. Kandidat menekan **Lamar** pada lowongan aktif.
2. Guest diarahkan ke login dan intended URL disimpan.
3. Kandidat login yang profilnya belum lengkap diarahkan ke Form Kandidat.
4. Kandidat lengkap melihat drawer konfirmasi node V2 `1:2457`.
5. Sistem memeriksa ulang status lowongan, kelengkapan profil, CV aktif, dan duplikasi.
6. Kandidat menekan **Lamar Sekarang**.
7. Tombol masuk ke state loading dan tidak dapat diklik ulang.
8. Server menyimpan snapshot profil, referensi versi dokumen, dan lamaran dalam transaction.
9. Sistem menampilkan feedback berhasil serta menambahkan item pada Riwayat Lamaran.

### 7.4 Mengirim CV Umum/Talent Pool

1. Kandidat menekan **Kirim CV Sekarang**.
2. Autentikasi dan kelengkapan profil diperiksa.
3. Kandidat memilih departemen, posisi, dan lokasi minat.
4. Sistem memvalidasi pilihan dan CV aktif.
5. Submission disimpan sebagai `talent_pool`, bukan sebagai lamaran ke job tertentu.
6. Submission muncul pada Riwayat Lamaran dengan label yang membedakannya dari lowongan spesifik.

### 7.5 Melihat Riwayat Lamaran

1. Kandidat membuka Form Kandidat.
2. Jika formulir belum lengkap, panel riwayat menampilkan locked/empty guidance.
3. Jika lengkap tetapi belum melamar, panel menampilkan empty state dan link **Kunjungi halaman Karir**.
4. Jika sudah melamar, panel menampilkan daftar aplikasi terbaru.
5. Setiap item minimal menampilkan nama posisi, departemen, lokasi, tanggal submit, dan status.
6. Hanya data milik user login yang dapat ditampilkan.

## 8. Functional Requirements

### 8.1 Header Form Kandidat

- Tinggi baseline desktop `81px` dengan surface putih dan border bawah.
- Memiliki back button menuju halaman Karir atau intended source yang aman.
- Judul: **Form Kandidat**.
- Subtitle incomplete: **Lengkapi data diri Anda untuk melamar pekerjaan**.
- Subtitle complete: **Data tersimpan. Lanjut lamar pekerjaan.**
- State complete menampilkan badge **Formulir Lengkap** dan tombol **Edit Form**.
- State edit menampilkan aksi **Batal Edit**.

### 8.2 Stepper Empat Langkah

Urutan tidak dapat diubah:

1. Data Induk — Informasi pribadi dasar.
2. Data Detail — Informasi detail kontak.
3. Data Pendidikan — Riwayat pendidikan.
4. Data Pengalaman — Pengalaman kerja.

State step:

- **Current:** lingkaran biru dengan nomor putih.
- **Complete:** lingkaran hijau dengan check dan connector hijau.
- **Upcoming:** lingkaran abu-abu dengan nomor dan connector abu-abu.
- **Read-only complete:** desain menampilkan step 1 aktif saat ringkasan dibuka; implementasi boleh mempertahankan step terakhir yang dibuka melalui query/session tanpa mengubah makna status.

Kandidat tidak boleh melompati step yang belum valid. Kandidat boleh kembali ke step sebelumnya tanpa kehilangan draft yang telah tersimpan.

### 8.3 Step 1 — Data Induk

| Field | UI Figma | Aturan Awal |
|---|---|---|
| Pas foto | Upload JPG/PNG, max 5 MB | Required pada desain; private; validasi MIME dan dimensi |
| Resume/CV | Upload PDF, max 5 MB | Required; private; versi aktif disimpan |
| Nama lengkap | Text | Required; prefill dari akun jika tersedia |
| Nomor KTP | Text 16 digit | Required pada desain; encrypted at rest direkomendasikan; keputusan retensi wajib |
| Tanggal lahir | Date | Required; tidak boleh tanggal masa depan |
| Tempat lahir | Text | Required |
| Jenis kelamin | Select | Required pada desain; opsi ditetapkan product/HR |
| Status pernikahan | Select | Required pada desain; wajib lolos review relevansi dan fairness |
| Golongan darah | Select | Required pada desain; wajib lolos review kebutuhan dan privasi |
| Agama | Select | Required pada desain; wajib lolos review relevansi dan fairness |

- File picker harus menampilkan nama file terpilih dan memungkinkan penggantian.
- Pas foto yang sudah tersimpan ditampilkan pada preview `96 × 128px` di baseline desktop.
- Data tidak boleh dianggap valid hanya karena field terlihat terisi pada client.
- Nomor KTP tidak boleh ditampilkan utuh pada log, analytics, URL, atau pesan error.

### 8.4 Step 2 — Data Detail

| Field | Tipe | Aturan |
|---|---|---|
| Tinggi badan | Integer, cm | Required pada desain; batas wajar dikonfigurasi server |
| Berat badan | Decimal/integer, kg | Required pada desain; batas wajar dikonfigurasi server |
| Kewarganegaraan | Text/select | Required; default visual “Indonesia” tidak boleh dipaksakan |
| Tempat tinggal | Text | Required; kota tempat tinggal |
| Alamat sesuai KTP | Textarea | Required pada desain |
| Nomor telepon | Tel | Required; normalisasi format sebelum simpan |
| Email | Email | Required; bersumber dari akun dan read-only kecuali flow perubahan email tersedia |
| Alamat domisili | Textarea | Required pada desain; boleh sama dengan alamat KTP melalui checkbox implementasi |

- Tinggi/berat badan hanya boleh dikumpulkan bila relevan dengan persyaratan pekerjaan dan disetujui HR/legal.
- Email profil harus konsisten dengan identitas akun; perubahan email tidak dilakukan diam-diam dari wizard.

### 8.5 Step 3 — Data Pendidikan

#### Pendidikan SMA/SMK — Required

| Field | Aturan |
|---|---|
| Nama sekolah | Required |
| Penjurusan/bidang keahlian | Required |
| Tahun mulai | Required, tahun valid |
| Tahun selesai | Required dan tidak lebih kecil dari tahun mulai |
| Nilai akhir rata-rata | Required pada desain; numeric dengan skala yang dijelaskan |
| Ijazah | PDF, max 5 MB, private |

#### Perguruan Tinggi — Opsional

- Kandidat dapat menambah maksimal empat entri.
- Empty state menampilkan **Belum ada data pendidikan perguruan tinggi** dan aksi **Tambah**.
- Setiap entri yang ditambahkan minimal menyimpan jenjang, institusi, program studi, tahun mulai, tahun selesai/masih berjalan, nilai akhir/IPK, dan ijazah bila diwajibkan HR.
- Detail expanded perguruan tinggi tidak tersedia pada node sumber; daftar field final dan kewajiban ijazah perguruan tinggi harus dikonfirmasi sebelum implementasi.
- Kandidat dapat menghapus entri sebelum finalisasi dengan konfirmasi non-browser-native.

### 8.6 Step 4 — Data Pengalaman

Kandidat wajib memilih salah satu:

- **Fresh Graduate**
- **Ada Pengalaman**

#### Fresh Graduate

- Tidak menampilkan form pengalaman perusahaan.
- Menampilkan informasi bahwa kandidat dapat menyimpan formulir tanpa riwayat kerja.
- Pilihan harus tersimpan eksplisit; ketiadaan record tidak boleh otomatis dianggap Fresh Graduate.

#### Ada Pengalaman

- Minimal satu dan maksimal tiga perusahaan.
- Setiap perusahaan memiliki blok yang dapat ditambah/dihapus.
- Blok pertama tidak boleh dihapus jika status tetap Ada Pengalaman.

| Kelompok | Field pada Desain |
|---|---|
| Perusahaan | Nama perusahaan |
| Jabatan awal | Nama jabatan, mulai bulan/tahun, akhir bulan/tahun, tugas dan tanggung jawab |
| Jabatan akhir | Nama jabatan, mulai bulan/tahun, akhir bulan/tahun, tugas dan tanggung jawab |
| Resign dan kompensasi | Tahun resign, gaji terakhir, alasan resign, ekspektasi gaji |
| Referensi kerja | Telepon perusahaan, nama atasan, telepon atasan |
| Dokumen | Paklaring PDF max 5 MB |

Aturan validasi:

- Periode jabatan akhir tidak boleh mendahului periode jabatan awal.
- Gaji disimpan sebagai angka, bukan string berformat `Rp`.
- Telepon perusahaan/atasan dinormalisasi.
- Kontak atasan hanya dikumpulkan dengan dasar pemrosesan dan pemberitahuan privasi yang sesuai.
- Field “Jabatan Akhir” untuk kandidat yang masih bekerja memerlukan opsi **Masih bekerja di sini** pada implementasi walaupun tidak terlihat pada frame; tanpa opsi ini, tanggal akhir akan memaksa data tidak benar.

### 8.7 Draft, Finalisasi, dan Kelengkapan

- Setiap step dapat disimpan sebagai draft.
- Validasi step mencegah perpindahan ke step berikutnya jika field wajib pada step tersebut tidak valid.
- `profile_completed_at` hanya diisi setelah seluruh aturan server terpenuhi.
- Status complete dihitung server-side dan tidak hanya bergantung pada nomor step terakhir.
- Mengedit profil lengkap tidak menghapus `profile_completed_at` kecuali data wajib menjadi tidak valid atau dokumen wajib dihapus.
- Submit lamaran harus melakukan revalidation kelengkapan pada saat request diproses.

### 8.8 Upload dan Dokumen

- Pas foto menerima JPEG/PNG sesuai desain; CV, ijazah, dan paklaring menerima PDF.
- Batas baseline setiap file: 5 MB.
- MIME aktual dan ekstensi harus divalidasi.
- Nama file penyimpanan dibuat server; nama file asli hanya metadata.
- File disimpan pada disk private dan tidak dapat diakses melalui `/storage/...` publik.
- Download/preview melalui controller terotorisasi atau temporary signed URL yang pendek masa berlakunya.
- Penggantian file membuat versi baru; file yang menjadi bagian snapshot lamaran tidak boleh berubah.
- File orphan dibersihkan melalui job terjadwal setelah masa aman.
- Malware scanning harus tersedia sebelum production atau dokumen ditandai `pending_scan` sampai pemeriksaan selesai.

### 8.9 Konfirmasi dan Submission Lamaran

- Drawer V2 `1:2457` digunakan kembali.
- Notice V3 dan tombol disabled dihapus setelah kandidat eligible.
- Submit hanya menerima `POST`, dilindungi CSRF dan rate limit.
- Job ditentukan dari server berdasarkan slug/id; client tidak boleh mengirim snapshot job sebagai sumber kebenaran.
- Server menolak job tidak published, belum dibuka, expired, atau closed.
- Server mencegah lamaran duplikat melalui validation dan database constraint.
- Data kandidat dan versi dokumen disnapshot pada saat submit.
- Penyimpanan menggunakan database transaction dan idempotency protection.
- Jika notifikasi gagal, lamaran yang berhasil disimpan tidak boleh ikut hilang.

### 8.10 Talent Pool / Kirim CV Sekarang

- Drawer V2 `1:2936` digunakan kembali dan field diaktifkan.
- Departemen, posisi, dan lokasi wajib diisi.
- Submission memiliki `type = talent_pool` dan `job_id = null`.
- Duplikasi talent pool ditentukan berdasarkan kebijakan periode; default yang disarankan adalah satu submission aktif per kandidat per kombinasi minat.
- Talent pool harus memiliki copy yang jelas bahwa data tidak menjamin adanya proses seleksi.

### 8.11 Riwayat Lamaran

- Panel locked sebelum formulir selesai mengikuti node incomplete.
- Empty state lengkap mengikuti node `1:3539`.
- State berisi data mengikuti node `1:4482`.
- Daftar diurutkan berdasarkan `submitted_at` terbaru.
- Status awal ditampilkan sebagai **Menunggu**.
- Minimal informasi: judul/jenis submission, departemen, lokasi, tanggal submit, dan status.
- Pagination diperlukan jika jumlah item melebihi batas yang ditentukan; baseline disarankan 10 per halaman.
- Riwayat menggunakan snapshot agar judul/lokasi tetap dapat dibaca saat lowongan diedit atau ditutup.

## 9. Data Model Minimum

### 9.1 `candidate_profiles`

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `user_id` | Unique foreign key ke `users` |
| `full_name` | Required |
| `national_id_encrypted` | Nullable sampai keputusan privasi; encrypted cast |
| `birth_date` | Date |
| `birth_place` | String |
| `gender` | String/enum terkontrol |
| `marital_status` | Nullable setelah privacy review |
| `blood_type` | Nullable setelah privacy review |
| `religion` | Nullable setelah privacy review |
| `height_cm` | Nullable integer setelah relevance review |
| `weight_kg` | Nullable decimal setelah relevance review |
| `nationality` | String |
| `residence_city` | String |
| `identity_address` | Text |
| `domicile_address` | Text |
| `phone` | String ter-normalisasi |
| `experience_status` | `fresh_graduate` atau `experienced` |
| `current_step` | Integer 1–4 |
| `profile_completed_at` | Nullable timestamp |
| timestamps | Required |

### 9.2 `candidate_documents`

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `user_id` | Foreign key |
| `type` | `photo`, `cv`, `high_school_diploma`, `college_diploma`, `employment_letter` |
| `disk` | Nama disk private |
| `path` | Path acak, tidak dapat ditebak |
| `original_name` | Nama file asli untuk tampilan |
| `mime_type` | MIME hasil inspeksi server |
| `size_bytes` | Ukuran file |
| `checksum` | Hash file untuk integritas/deduplikasi |
| `scan_status` | `pending`, `clean`, `rejected` |
| `is_active` | Menandai versi aktif per konteks |
| timestamps | Required |

### 9.3 `candidate_educations`

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `candidate_profile_id` | Foreign key |
| `level` | `high_school`, diploma/sarjana/pascasarjana terkontrol |
| `institution_name` | Required |
| `field_of_study` | Required |
| `start_year` | Required |
| `end_year` | Nullable jika masih berjalan |
| `final_score` | Nullable decimal |
| `document_id` | Nullable foreign key ke dokumen |
| `sort_order` | Integer |
| timestamps | Required |

Satu record `high_school` wajib; maksimal empat record perguruan tinggi.

### 9.4 `candidate_work_experiences`

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `candidate_profile_id` | Foreign key |
| `company_name` | Required |
| `initial_title` | Required |
| `initial_started_at` / `initial_ended_at` | Month precision |
| `initial_responsibilities` | Text |
| `final_title` | Required |
| `final_started_at` / `final_ended_at` | Month precision; end nullable jika masih bekerja |
| `final_responsibilities` | Text |
| `is_current` | Boolean |
| `resign_year` | Nullable |
| `last_salary` | Nullable integer/decimal |
| `resign_reason` | Nullable text |
| `expected_salary` | Nullable integer/decimal |
| `company_phone` | Nullable string |
| `supervisor_name` | Nullable string |
| `supervisor_phone` | Nullable string |
| `employment_letter_document_id` | Nullable foreign key |
| `sort_order` | Integer 1–3 |
| timestamps | Required |

### 9.5 `applications`

| Field | Tipe/Aturan |
|---|---|
| `id` | Primary key |
| `user_id` | Foreign key kandidat |
| `job_id` | Nullable untuk talent pool |
| `department_id` | Required untuk talent pool atau snapshot reference |
| `position_id` | Required untuk talent pool atau snapshot reference |
| `location_id` | Required untuk talent pool atau snapshot reference |
| `type` | `job_application` atau `talent_pool` |
| `status` | Default `pending`; label kandidat **Menunggu** |
| `candidate_snapshot` | JSON profil relevan saat submit |
| `job_snapshot` | JSON judul/departemen/lokasi saat submit |
| `document_snapshot` | JSON ID/versi dokumen saat submit |
| `submitted_at` | Required |
| timestamps | Required |

Database wajib mencegah lamaran job ganda. Constraint talent pool mengikuti kebijakan periode yang disetujui.

### 9.6 Relasi Model

- `User hasOne CandidateProfile`.
- `User hasMany CandidateDocument`.
- `User hasMany Application`.
- `CandidateProfile hasMany CandidateEducation`.
- `CandidateProfile hasMany CandidateWorkExperience`.
- `Application belongsTo User`.
- `Application belongsTo Job` secara nullable.
- `Application belongsTo Department`, `Position`, dan `Location` sesuai tipe submission.

## 10. Business Rules

1. Profil dan lamaran hanya dapat dikelola user terautentikasi.
2. Email kandidat berasal dari akun autentikasi.
3. Kandidat harus menyelesaikan keempat step sebelum submit.
4. Fresh Graduate tidak wajib membuat record pengalaman kerja.
5. Kandidat berpengalaman wajib memiliki minimal satu dan maksimal tiga perusahaan.
6. Pendidikan SMA/SMK wajib; perguruan tinggi opsional maksimal empat.
7. CV aktif, pas foto, dan dokumen wajib harus lolos validasi sebelum profil complete.
8. Lamaran spesifik hanya dapat dikirim ketika lowongan masih publik dan aktif.
9. Satu kandidat hanya dapat mengirim satu lamaran untuk lowongan yang sama.
10. Talent pool bukan lamaran ke lowongan aktif.
11. Snapshot profil, job, dan dokumen tidak berubah ketika profil kandidat diedit.
12. Kandidat hanya dapat membaca profil, file, dan riwayat miliknya sendiri.
13. Status `pending` ditampilkan sebagai **Menunggu**; transisi status bukan wewenang kandidat.
14. Penghapusan akun/dokumen yang telah menjadi arsip lamaran mengikuti kebijakan retensi, bukan hard delete langsung.
15. Data sensitif hanya dikumpulkan apabila memiliki tujuan rekrutmen yang terdokumentasi.

## 11. State dan Error Handling

### 11.1 Wizard Profil

- Initial, draft, current, complete, read-only, edit, dirty, saving, saved, dan failed.
- Validasi inline per field dan summary error pada awal card.
- Session kedaluwarsa ketika menyimpan.
- Konflik perubahan dari dua tab/perangkat.
- File berhasil tetapi penyimpanan profil gagal, atau sebaliknya.
- File hilang/ditolak malware scan setelah sebelumnya dipilih.

### 11.2 Upload

- Idle, drag-over/focused, uploading, uploaded, replacing, invalid type, oversized, scan pending, rejected, dan failed.
- Progress ditampilkan jika upload asynchronous digunakan.
- File lama tidak dihapus sampai file pengganti berhasil tervalidasi dan disimpan.

### 11.3 Lamaran

- Profil belum lengkap.
- CV tidak tersedia, invalid, atau scan belum bersih.
- Lowongan ditutup saat drawer terbuka.
- Lamaran duplikat.
- Submit sedang diproses.
- Submit berhasil tetapi notifikasi gagal.
- Request diulang akibat refresh/network retry.

### 11.4 Riwayat

- Locked sebelum profil complete.
- Empty setelah profil complete.
- Loaded dengan satu/banyak item.
- Pagination loading.
- Error dengan tombol coba lagi.

## 12. Privasi, Fairness, dan Keputusan Wajib

Desain meminta data yang dapat menimbulkan risiko privasi atau bias rekrutmen. Asterisk pada Figma tidak otomatis menjadi dasar bahwa field harus wajib di production.

| Kelompok Data | Risiko | Keputusan Sebelum Production |
|---|---|---|
| Nomor KTP | Identitas unik dan penyalahgunaan identitas | Tujuan, enkripsi, masking, retensi, akses |
| Agama, status pernikahan, gender | Potensi diskriminasi/fairness | Relevansi pekerjaan dan legal/HR approval |
| Golongan darah, tinggi, berat | Data kesehatan/fisik | Hanya untuk peran dengan persyaratan sah dan jelas |
| Alamat lengkap | Paparan lokasi pribadi | Minimalkan detail dan batasi akses |
| Gaji dan ekspektasi | Data finansial kandidat | Batasi akses dan log |
| Nama/telepon atasan | Data pihak ketiga | Notice/consent serta tujuan verifikasi |
| Ijazah dan paklaring | Dokumen pribadi | Retensi, akses, malware scan, deletion |

Sebelum production wajib tersedia:

- privacy notice yang dapat dibuka sebelum submit;
- persetujuan pemrosesan data yang tercatat;
- kebijakan retensi dan penghapusan;
- daftar role yang dapat mengakses setiap kategori data;
- audit akses dokumen sensitif pada Versi 4;
- keputusan field mana yang benar-benar required per jenis posisi.

## 13. Non-Functional Requirements

### 13.1 Responsif

- Mobile: `< 640px`; tablet: `640–1024px`; desktop: `> 1024px`.
- Wrapper desktop `1024px` dan card `960px` menjadi max-width, bukan width kaku.
- Form dua kolom berubah menjadi satu kolom pada mobile.
- Stepper tetap dapat dipahami tanpa horizontal overflow; label dapat dipersingkat secara aksesibel atau menggunakan progress summary.
- Card pengalaman yang panjang tidak boleh memaksa zoom-out.
- Action tetap terlihat tanpa menutup field terakhir dan aman terhadap mobile safe-area.
- Target sentuh minimal `44 × 44px`, walaupun baseline tombol Figma `36px`.

### 13.2 Performa

- Initial server response tidak bergantung pada JavaScript untuk menampilkan data tersimpan.
- Upload besar tidak dimuat ke memory secara berlebihan.
- Daftar riwayat dipaginasi dan eager-load relasi yang digunakan.
- Foto memiliki dimensi eksplisit dan versi thumbnail.
- Dokumen tidak dikirim ke browser sampai kandidat meminta preview/download.

### 13.3 Aksesibilitas

- Target WCAG 2.2 AA.
- Stepper menggunakan struktur list dan menandai step aktif dengan `aria-current="step"`.
- Setiap field memiliki label, required state, help text, dan error yang terasosiasi.
- Upload dapat digunakan keyboard; dropzone bukan satu-satunya metode.
- Radio Fresh Graduate/Ada Pengalaman menggunakan `fieldset` dan `legend`.
- Dynamic education/experience mengumumkan penambahan/penghapusan dengan live region.
- Status tidak disampaikan hanya melalui warna.
- Focus berpindah ke heading step setelah navigasi atau error summary setelah gagal validasi.

### 13.4 Keamanan

- CSRF, rate limit, authorization policy, mass-assignment protection, dan server validation wajib.
- Nomor KTP direkomendasikan menggunakan encrypted cast dan masked display.
- Dokumen disimpan private dengan path acak.
- Original filename tidak digunakan sebagai storage filename.
- Content-Type response dan `Content-Disposition` dikontrol saat download.
- Upload harus menolak executable, polyglot yang terdeteksi, file rusak, dan MIME palsu.
- Log tidak memuat isi field sensitif, token, atau path internal file.
- Submit lamaran menggunakan transaction dan unique constraint.

### 13.5 Reliability dan Observability

- Kegagalan upload, finalisasi profil, dan submit dicatat tanpa PII sensitif.
- Operasi submit harus idempotent.
- Queue notification dapat di-retry tanpa membuat lamaran baru.
- Backup database dan private storage harus konsisten dengan kebijakan deployment.

## 14. Acceptance Criteria

### 14.1 Integrasi Versi 2

- [ ] Home dan katalog Karir Versi 2 tidak mengalami regresi.
- [ ] User guest/login dan intended URL tetap berfungsi.
- [ ] Notice V3 hanya hilang setelah flow pengganti tersedia.
- [ ] Branch implementasi berasal dari `main` yang sudah memuat V2.

### 14.2 Form Kandidat

- [ ] `/karir/profile` hanya dapat dibuka kandidat login.
- [ ] Empat step sesuai delapan node sumber.
- [ ] Draft step sebelumnya tidak hilang ketika navigasi.
- [ ] Field, label, upload, dan conditional experience divalidasi server-side.
- [ ] Fresh Graduate dapat finalisasi tanpa record pengalaman.
- [ ] Ada Pengalaman membutuhkan 1–3 record perusahaan.
- [ ] SMA/SMK wajib dan perguruan tinggi maksimal empat.
- [ ] State complete, edit, dan cancel edit bekerja.

### 14.3 Dokumen

- [ ] Foto hanya menerima tipe yang disetujui dan maksimal 5 MB.
- [ ] CV, ijazah, dan paklaring hanya menerima PDF maksimal 5 MB.
- [ ] File tidak tersedia melalui URL public storage.
- [ ] Kandidat tidak dapat membuka dokumen kandidat lain.
- [ ] Penggantian dokumen tidak mengubah snapshot lamaran lama.

### 14.4 Submission

- [ ] Kandidat incomplete diarahkan ke profil dengan intended action.
- [ ] Kandidat complete dapat mengirim lamaran aktif.
- [ ] Lowongan expired/closed ditolak di server.
- [ ] Lamaran duplikat dicegah di server dan database.
- [ ] Double-click/network retry tidak membuat record ganda.
- [ ] Talent pool disimpan dengan `job_id = null` dan minat lengkap.
- [ ] Feedback loading, success, duplicate, expired, dan failure tersedia.

### 14.5 Riwayat

- [ ] Locked state sesuai desain sebelum profil complete.
- [ ] Empty state sesuai node `1:3539`.
- [ ] State berisi lamaran sesuai node `1:4482`.
- [ ] Kandidat hanya melihat lamaran sendiri.
- [ ] Item menampilkan snapshot informasi saat submit.

### 14.6 Quality Gate

- [ ] Feature test mencakup seluruh authorization dan validation penting.
- [ ] Test memastikan private file tidak dapat diakses lintas user.
- [ ] Test duplicate application dan idempotency lulus.
- [ ] Migration dapat dijalankan di atas database V1/V2 tanpa `migrate:fresh`.
- [ ] Production build berhasil.
- [ ] Tampilan diuji pada mobile, tablet, desktop, keyboard, dan zoom 200%.
- [ ] Review privasi field sensitif telah disetujui sebelum production.

## 15. Test Matrix Minimum

| Area | Skenario Minimum |
|---|---|
| Auth | guest redirect, intended URL, session expired |
| Profile | create draft, resume draft, complete, edit, cancel, ownership |
| Step validation | invalid KTP/date/phone/year/score/salary/timeline |
| Conditional experience | fresh graduate, experienced 0/1/3/4 companies |
| Upload | valid, MIME palsu, oversize, replacement, unauthorized download |
| Application | success, duplicate, expired, closed, incomplete profile, missing CV |
| Talent pool | success, missing interest, duplicate policy |
| History | locked, empty, loaded, own records only, pagination |
| Regression | Home, contact, career list/filter/detail/auth/sitemap |

## 16. Out of Scope Versi 3

- Panel admin/HR.
- CRUD departemen, posisi, lokasi, dan lowongan oleh HR.
- Review CV, shortlist, interview, offering, hired, atau rejected oleh HR.
- Download dokumen melalui UI HR.
- Email template workflow rekrutmen lengkap.
- WhatsApp/SMS notification.
- Social login dan SSO.
- Assessment online, video interview, dan employee referral.
- Integrasi job board eksternal.
- OCR KTP/ijazah/CV dan parsing CV otomatis.
- Candidate matching atau ranking berbasis AI.
- Portofolio multi-file kecuali diputuskan sebagai perubahan scope.
- Penghapusan akun mandiri sebelum kebijakan retensi disetujui.

## 17. Keputusan Produk dan Open Questions

### 17.1 Sudah Ditetapkan

1. Wizard memiliki empat step sesuai Figma.
2. CV wajib berupa PDF maksimal 5 MB.
3. Foto berupa JPG/PNG maksimal 5 MB menurut copy desain.
4. SMA/SMK wajib; perguruan tinggi opsional maksimal empat.
5. Pengalaman membedakan Fresh Graduate dan Ada Pengalaman.
6. Kandidat berpengalaman dapat menyimpan maksimal tiga perusahaan.
7. Riwayat lamaran tersedia setelah formulir selesai.
8. Status awal kandidat adalah **Menunggu**.
9. Panel HR tetap berada di Versi 4.

### 17.2 Wajib Diputuskan Sebelum Production

1. Apakah KTP, agama, status pernikahan, golongan darah, tinggi, dan berat benar-benar wajib untuk seluruh lowongan atau hanya posisi tertentu.
2. Apakah nomor KTP disimpan penuh, masked token, atau baru dikumpulkan pada tahap seleksi berikutnya.
3. Daftar opsi gender, agama, status pernikahan, golongan darah, pendidikan, dan kewarganegaraan.
4. Field lengkap perguruan tinggi dan kewajiban upload ijazahnya.
5. Dukungan kandidat yang masih bekerja pada pengalaman terakhir.
6. Masa retensi profil, CV, ijazah, paklaring, dan lamaran.
7. Copy consent dan privacy notice.
8. Aturan duplicate talent pool dan masa aktifnya.
9. Apakah verifikasi email wajib sebelum submit.
10. Apakah notifikasi acknowledgement email termasuk release V3 atau deferred.

## 18. Milestone Implementasi

### Milestone 1 — Fondasi Data dan Security

- Migration additive untuk profil, dokumen, pendidikan, pengalaman, dan lamaran.
- Model, relation, enum/value object, policy, dan private disk.
- Form Request serta service untuk dokumen dan kelengkapan.

### Milestone 2 — Wizard Profil

- Header, stepper, step 1–4, draft persistence, conditional fields.
- State incomplete, complete, read-only, edit, dan cancel.
- Upload foto, CV, ijazah, dan paklaring.

### Milestone 3 — Submission

- Aktifkan drawer apply dan send CV Versi 2.
- Eligibility check, snapshot, duplicate prevention, idempotency, dan feedback.

### Milestone 4 — Riwayat Kandidat

- Locked, empty, loaded, status badge, dan pagination.
- Authorized document preview untuk kandidat.

### Milestone 5 — QA dan Release

- Feature/regression/security/accessibility/responsive tests.
- UAT product owner/HR.
- Privacy approval, production build, migration rehearsal, dan deployment checklist.

## 19. Migration dan Release Safety

- Semua migration bersifat additive dan tidak menghapus data V1/V2.
- Jangan menggunakan `php artisan migrate:fresh` pada database existing.
- Backup database dan file storage dilakukan sebelum production migration.
- Jalankan migration pada salinan database terlebih dahulu.
- Seeder lowongan V2 tidak dijalankan ulang secara destruktif.
- Rollback migration diuji tanpa menghapus tabel V1/V2.
- `.env` tetap lokal/server-only dan tidak masuk Git.

## 20. Definition of Done

Versi 3 dinyatakan selesai ketika kandidat dapat membuat profil melalui empat step, menyimpan file secara private, mengedit profil, mengirim lamaran spesifik atau talent pool tanpa duplikasi, serta melihat riwayatnya sendiri. Seluruh authorization, validation, snapshot, upload security, responsive behavior, dan automated tests harus lulus. Home Versi 1 serta katalog/auth Versi 2 tidak boleh mengalami regresi. Panel dan workflow HR bukan syarat selesai Versi 3 dan tetap menjadi scope Versi 4.

# Panduan Menjalankan Website TVIP untuk Pemula

Panduan ini ditujukan untuk pengguna Windows 10 atau Windows 11 yang belum terbiasa menggunakan Laravel.

## A. Program yang Harus Dipasang

Sebelum membuka project, pasang dua program berikut:

1. **Laragon Full**
   - Laragon menyediakan PHP, MySQL, terminal, dan alat pendukung Laravel.
   - Pastikan PHP yang aktif adalah versi **8.3 atau lebih baru**.

2. **Node.js versi LTS**
   - Node.js dipakai untuk membangun tampilan Tailwind CSS dan Alpine.js.

Setelah instalasi selesai, restart komputer agar semua program terdeteksi dengan benar.

## B. Menyiapkan Folder Project

1. Download file `tvip-company-profile.zip`.
2. Buka File Explorer.
3. Masuk ke folder tempat Laragon dipasang. Biasanya:

   ```text
   C:\laragon\www
   ```

4. Pindahkan file ZIP ke folder tersebut.
5. Klik kanan file ZIP, lalu pilih **Extract All** atau **Ekstrak Semua**.
6. Pastikan hasil akhirnya menjadi:

   ```text
   C:\laragon\www\tvip-company-profile-ori
   ```

7. Pastikan file `artisan`, `composer.json`, dan `package.json` terlihat di dalam folder tersebut.

## C. Menyalakan Laragon

1. Buka aplikasi Laragon.
2. Klik tombol **Start All**.
3. Tunggu sampai Apache/Nginx dan MySQL berstatus aktif.
4. Dari Laragon, klik **Menu > Terminal**.

Gunakan terminal milik Laragon agar perintah PHP dan Composer lebih mudah dikenali.

## D. Masuk ke Folder Project

Salin perintah berikut ke terminal, lalu tekan Enter:

```bat
cd C:\laragon\www\tvip-company-profile-ori
```

Periksa PHP:

```bat
php -v
```

Versi PHP harus 8.3 atau lebih baru.

Periksa Composer dan Node.js:

```bat
composer -V
node -v
npm -v
```

Jika semuanya menampilkan nomor versi, lanjutkan ke langkah berikutnya.

## E. Membuat File Pengaturan Project

Jalankan:

```bat
copy .env.example .env
```

Kemudian buat kunci keamanan Laravel:

```bat
php artisan key:generate
```

Setelah berhasil, terminal akan menampilkan pesan bahwa application key sudah dibuat.

## F. Memasang Komponen Laravel

Jalankan:

```bat
composer install
```

Tunggu sampai proses selesai. Jangan tutup terminal saat proses berjalan.

## G. Membuat Database

1. Buka Laragon.
2. Klik **Menu > MySQL > HeidiSQL** atau tombol **Database**.
3. Buka koneksi lokal. Pengaturan Laragon biasanya:
   - User: `root`
   - Password: kosong
4. Klik kanan nama koneksi atau bagian database.
5. Pilih **Create new > Database**.
6. Isi nama database:

   ```text
   tvip_company_profile_ori
   ```

7. Klik OK.

Project sudah memakai pengaturan database bawaan berikut:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tvip_company_profile_ori
DB_USERNAME=root
DB_PASSWORD=
```

Jika MySQL Anda memakai password, buka file `.env` dengan Notepad lalu isi `DB_PASSWORD` sesuai password MySQL.

## H. Membuat Tabel Database

Kembali ke terminal Laragon. Jalankan:

```bat
php artisan migrate
```

Saat diminta konfirmasi, ketik `yes` lalu tekan Enter.

Perintah ini akan membuat tabel, termasuk tabel `contact_messages` untuk menyimpan pesan dari form kontak.

## I. Memasang dan Membangun Tampilan Website

Jalankan dua perintah berikut secara berurutan:

```bat
npm install
```

Setelah selesai, jalankan:

```bat
npm run build
```

Jika proses berhasil, folder `public/build` akan dibuat otomatis.

## J. Pengaturan Email untuk Uji Lokal

Untuk tahap awal, email asli belum perlu diaktifkan.

1. Buka file `.env` memakai Notepad.
2. Cari baris:

   ```env
   MAIL_MAILER=smtp
   ```

3. Ubah menjadi:

   ```env
   MAIL_MAILER=log
   ```

4. Simpan file.

Dengan pengaturan ini, pesan kontak tetap masuk ke database. Salinan email hanya dicatat di file:

```text
storage\logs\laravel.log
```

SMTP asli dapat diisi nanti saat website siap dipasang di hosting.

## K. Menjalankan Website

Di terminal Laragon, jalankan:

```bat
php artisan serve
```

Jika berhasil, akan muncul alamat seperti:

```text
http://127.0.0.1:8000
```

Buka Google Chrome, lalu kunjungi:

```text
http://127.0.0.1:8000
```

Jangan tutup terminal selama website masih digunakan.

## L. Pengujian Dasar

Setelah website terbuka, periksa hal berikut:

1. Logo dan gambar tampil.
2. Menu **Home** kembali ke bagian atas.
3. Menu **Tentang Kami** menggulir ke bagian Visi, Misi, dan S.U.P.E.R Team.
4. Menu **Kontak Kami** menggulir ke bagian kontak.
5. Tombol **Hubungi Kami** atau **Hubungi Sekarang** membuka form kontak.
6. Isi form lalu kirim.
7. Pastikan pesan berhasil tampil.

Untuk melihat data pesan:

1. Buka HeidiSQL.
2. Pilih database `tvip_company_profile`.
3. Pilih tabel `contact_messages`.
4. Buka tab **Data**.

## M. Cara Menjalankan Lagi Besok

Setelah instalasi pertama selesai, langkah harian jauh lebih singkat:

1. Buka Laragon.
2. Klik **Start All**.
3. Buka **Menu > Terminal**.
4. Jalankan:

   ```bat
   cd C:\laragon\www\tvip-company-profile-ori
   php artisan serve
   ```

5. Buka:

   ```text
   http://127.0.0.1:8000
   ```

Tidak perlu menjalankan `composer install`, `npm install`, atau `php artisan migrate` setiap hari.

## N. Cara Menghentikan Website

1. Klik terminal yang menjalankan website.
2. Tekan tombol:

   ```text
   Ctrl + C
   ```

3. Setelah selesai, klik **Stop** atau **Stop All** pada Laragon.

## O. Masalah yang Sering Muncul

### 1. Pesan: `php is not recognized`

Buka terminal dari Laragon, bukan Command Prompt biasa. Pastikan Laragon sudah dijalankan.

### 2. Pesan: PHP version is not supported

Project membutuhkan PHP 8.3 atau lebih baru. Aktifkan PHP 8.3+ melalui menu Laragon.

### 3. Pesan: `composer is not recognized`

Pastikan Composer tersedia di Laragon. Tutup lalu buka kembali Laragon setelah instalasi.

### 4. Pesan: `Unknown database 'tvip_company_profile'`

Database belum dibuat. Ulangi bagian **G. Membuat Database**.

### 5. Pesan: `Access denied for user 'root'`

Password MySQL tidak sesuai. Buka `.env`, lalu isi `DB_USERNAME` dan `DB_PASSWORD` dengan benar.

### 6. Pesan: `Vite manifest not found`

Jalankan:

```bat
npm install
npm run build
```

### 7. Port 8000 sedang dipakai

Gunakan port lain:

```bat
php artisan serve --port=8001
```

Lalu buka:

```text
http://127.0.0.1:8001
```

### 8. Halaman error setelah mengubah `.env`

Jalankan:

```bat
php artisan config:clear
php artisan cache:clear
```

Lalu jalankan kembali:

```bat
php artisan serve
```

### 9. Email tidak masuk ke inbox

Pengaturan lokal memakai `MAIL_MAILER=log`, sehingga email belum dikirim ke inbox. Data pesan tetap tersimpan di tabel `contact_messages`. SMTP asli perlu dikonfigurasi saat website siap online.

## P. Perintah Lengkap Instalasi Pertama

Setelah database dibuat, seluruh perintah utama dapat dijalankan satu per satu:

```bat
cd C:\laragon\www\tvip-company-profile-ori
copy .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

Buka website di:

```text
http://127.0.0.1:8000
```

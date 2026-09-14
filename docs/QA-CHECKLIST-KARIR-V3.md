# QA Checklist — Karir V3

## Setup Aman

- [ ] Checkout branch implementasi V3 dan pastikan `.env` tetap memakai database yang benar.
- [ ] Jalankan `composer install` dan `npm install` bila dependency belum tersedia.
- [ ] Jalankan `php artisan migrate` (jangan memakai `migrate:fresh` pada database berisi data).
- [ ] Jalankan `php artisan db:seed --class=CareerSeeder` bila master lowongan belum tersedia.
- [ ] Jalankan `npm run build`.

## Automated Check

```bash
php artisan test
npm run build
```

## Profil Kandidat

- [ ] Guest yang membuka `/karir/profile` diarahkan ke login.
- [ ] Step 1 menerima JPG/PNG dan CV PDF maksimal 5 MB; tipe/ukuran salah menampilkan error inline.
- [ ] NIK tersimpan terenkripsi dan hanya tampil masked pada ringkasan.
- [ ] Step berikutnya tidak dapat dilompati sebelum step aktif valid.
- [ ] Pendidikan SMA/SMK dan ijazah wajib; perguruan tinggi dapat ditambah maksimal empat.
- [ ] Fresh Graduate dapat menyelesaikan profil tanpa pengalaman kerja.
- [ ] Kandidat berpengalaman wajib memiliki 1–3 perusahaan, periode Jabatan Awal/Akhir, dan tanggung jawab.
- [ ] Data tersimpan muncul pada ringkasan; Edit dan Batal Edit tidak menghapus data lama.
- [ ] Layout tetap satu kolom dan seluruh field terjangkau pada viewport sempit/zoom 200%.

## Dokumen dan Privasi

- [ ] Dokumen tidak tersedia melalui `/storage/...` atau direktori `public`.
- [ ] Pemilik dapat membuka dokumennya melalui route terotorisasi.
- [ ] User lain memperoleh HTTP 403 untuk dokumen yang bukan miliknya.
- [ ] Mengganti dokumen membuat versi baru; snapshot lamaran lama tetap merujuk versi lama.
- [ ] Environment production memiliki malware scanner/private object storage sebelum release.

## Lamaran dan Talent Pool

- [ ] Kandidat incomplete diarahkan ke profil dari aksi Lamar/Kirim CV.
- [ ] Kandidat complete melihat preview profil dan CV pada drawer.
- [ ] Submit job yang aktif membuat satu application berstatus **Menunggu**.
- [ ] Klik/submit ulang tidak membuat duplikasi.
- [ ] Job expired/closed ditolak saat POST meskipun drawer sebelumnya masih terbuka.
- [ ] Talent pool mewajibkan departemen, posisi dalam departemen tersebut, dan lokasi.
- [ ] Riwayat menampilkan empty, loaded, pagination, tipe submission, tanggal, dan status yang benar.

## Production Gate

- [ ] HR/legal menyetujui tujuan dan kebutuhan setiap field sensitif.
- [ ] Privacy notice, consent record, retensi, penghapusan, serta role akses telah ditetapkan.
- [ ] V4 menyediakan audit akses dokumen sebelum HR memperoleh akses operasional.

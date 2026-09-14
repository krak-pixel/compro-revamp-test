# Catatan Implementasi TVIP

## Source of Truth

1. Figma MCP file `yn2rF2dwEivl7pQow9EBXp`
2. `DESIGN.md` dan `DESIGN-FIGMA-KARIR-V2.md`
3. `PRD-KARIR-V2.md`

Node Karir yang diverifikasi:

- Guest Career `1:756`
- Authenticated Career `1:1153`
- Login `1:105`
- Register `1:152`
- Poster modal `1:1563`
- Detail drawer `1:1974`
- Apply preview `1:2457`
- Send CV preview `1:2936`

## Keputusan Implementasi

- Halaman Home menggunakan satu route `/`.
- `#tentang-kami` dan `#kontak-kami` memakai `scroll-margin-top: 64px` melalui class `scroll-mt-16`.
- Route Karir dan link shared navigation/footer sudah aktif.
- Daftar lowongan memakai database, server-side filter, URL state, dan pagination enam item per halaman.
- Registrasi diarahkan ke login manual sesuai keputusan produk.
- Profil, upload CV, dan submission tidak dibuat pada V2; preview drawer disabled menjelaskan dependency V3.
- Panel HR tidak dibuat pada V2 dan menjadi scope V4.
- Native `<select>` dipilih secara sadar karena popup platform dapat diterima dan tidak ada primitive listbox canonical di V1.
- CTA `Hubungi Sekarang` membuka modal form kontak. Modal tidak mengubah tampilan default Figma sebelum pengguna berinteraksi.
- Link sosial dan legal yang belum memiliki URL ditampilkan sebagai teks non-interaktif, bukan tautan palsu.
- Seluruh aset visual disimpan permanen dalam project.
# Versi 3 — Profil Kandidat dan Lamaran

- Menambahkan wizard profil kandidat empat langkah, ringkasan read-only, mode edit per langkah, serta riwayat lamaran.
- Menambahkan model dan migration additive untuk profil, dokumen privat, pendidikan, pengalaman kerja, dan aplikasi.
- NIK memakai encrypted cast. Dokumen tidak disimpan di `public/`; akses melewati route auth dan policy pemilik.
- Mengaktifkan drawer lamaran spesifik dan talent pool dengan validasi kelengkapan profil serta deduplication key.
- Status awal aplikasi adalah `pending` dan ditampilkan sebagai **Menunggu**. Pemrosesan oleh HR tetap scope V4.
- `scan_status` dokumen dimulai sebagai `pending_scan`; integrasi antivirus/object storage production masih membutuhkan keputusan infrastruktur.
- Field identitas sensitif mengikuti Figma/PRD, tetapi production release tetap memerlukan persetujuan HR/legal mengenai tujuan, retensi, akses, dan consent copy.

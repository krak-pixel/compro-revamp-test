# Catatan Implementasi TVIP

## Source of Truth

1. Figma MCP file `DoumhkxHYEpvTYrLffAv6V`
2. `DESIGN-FIGMA.md`
3. `PRD.md`

Node yang diverifikasi:

- Navigation `343:1012`
- HeroSection `343:781`
- VisionMissionSection `343:811`
- ContactSection `343:896`
- Footer `343:941`

## Keputusan Implementasi

- Halaman Home menggunakan satu route `/`.
- `#tentang-kami` dan `#kontak-kami` memakai `scroll-margin-top: 64px` melalui class `scroll-mt-16`.
- Route Karir belum dibuat. Link ditampilkan dalam keadaan nonaktif.
- CTA `Hubungi Sekarang` membuka modal form kontak. Modal tidak mengubah tampilan default Figma sebelum pengguna berinteraksi.
- Link sosial dan legal memakai placeholder karena URL final tidak tersedia pada sumber.
- Seluruh aset visual disimpan permanen dalam project.

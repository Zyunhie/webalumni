# TODO - Hero slide global (Mode B)

- [ ] Buat partial hero global: `resources/views/components/hero-global.blade.php`
  - Ambil hero slides dari `hero_slides`.
  - Home/beranda/dashboard: ambil **4** slide (page = `home` atau `beranda` atau `home/dashboard` sesuai data).
  - Halaman lain: ambil **1** slide (page sesuai nama halaman: `berita`, `lowongan`, `kontak`, `agenda`, `testimoni`, `tentang`, `alumni`, dll).
  - Fallback: `images/Branda.jpg`.
- [ ] Edit `resources/views/layouts/app.blade.php` untuk memanggil partial hero global.
- [ ] Bersihkan/abaikan penggunaan variabel hero manual di beberapa blade agar tidak bentrok (tetap aman kalau variabel belum dikirim).
- [ ] Jalankan `php artisan view:clear` dan uji minimal:
  - `GET /` (home)
  - `GET /dashboard` (admin)
  - `GET /admin/berita`
  - `GET /admin/lowongan`
  - `GET /berita`, `GET /lowongan`, `GET /kontak`

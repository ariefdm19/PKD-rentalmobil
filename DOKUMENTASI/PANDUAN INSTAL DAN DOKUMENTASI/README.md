# DOKUMENTASI & PANDUAN INSTALASI SISTEM PKD RENTAL MOBIL

Selamat datang di paket aplikasi **PKD Rental Mobil** - Sistem Manajemen Rental Kendaraan, Booking Online, Kontrak Sewa Otomatis & Laporan Keuangan berbasis Laravel 11 & MySQL.

---

## 📁 Struktur Direktori Dokumentasi

1. 📄 **[PANDUAN_INSTALASI_DAN_DOKUMENTASI.pdf](./PANDUAN_INSTALASI_DAN_DOKUMENTASI.pdf)**  
   Buku panduan lengkap bergambar (Cover, Spesifikasi, Langkah Instalasi Laragon, Instalasi cPanel/VPS, Dokumentasi Seluruh Menu, Troubleshooting).
2. 🖼️ **[promo/SAMPUL_PROMO_RENTAL_MOBIL_1080x1080.png](./promo/SAMPUL_PROMO_RENTAL_MOBIL_1080x1080.png)**  
   Sampul promosi komersial resolusi 1080x1080 dengan mockup layar PC Desktop dan Smartphone.
3. 🎥 **[video/PKD_Rental_Mobil_Tutorial.mp4](./video/PKD_Rental_Mobil_Tutorial.mp4)**  
   Video tutorial interaktif seluruh alur menu (Katalog, Detail, Sewa, Admin Dashboard, Armada, Sopir, Kontrak, Denda, Pembayaran, Servis, Laporan).
4. 📸 **[screenshots/](./screenshots/)**  
   Koleksi 21 tangkapan layar seluruh menu (Desktop & Mobile) dengan watermark resmi **Pintar Kreatif Digital**.

---

## ⚡ Ringkasan Cepat Instalasi Lokal (Laragon)

1. Letakkan folder ini di `C:\laragon\www\PKD-rentalmobil`.
2. Buat database baru bernama `pkd_rentalmobil` di HeidiSQL / phpMyAdmin.
3. Sesuaikan file `.env` (DB_DATABASE=pkd_rentalmobil, DB_USERNAME=root, DB_PASSWORD=).
4. Buka Terminal Laragon, jalankan:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
   ```
5. Buka browser di `http://127.0.0.1:8000` atau `http://localhost:8000`.

### 🔑 Akun Default:
- **Admin**: `admin@pkd.com` | Password: `admin123`
- **Petugas**: `petugas@pkd.com` | Password: `petugas123`
- **Pelanggan**: `pelanggan@pkd.com` | Password: `pelanggan123`

---
*Dikeluarkan dan didukung secara resmi oleh **Pintar Kreatif Digital**.*

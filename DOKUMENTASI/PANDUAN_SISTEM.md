# PANDUAN LENGKAP APLIKASI PKD RENTAL MOBIL (SIAP JUAL / KOMERSIAL)

**PKD Rental Mobil** adalah platform sistem manajemen rental mobil profesional berbasis **Laravel 12** dan **MySQL** yang dirancang khusus untuk pengusaha rental kendaraan, agen travel, serta persewaan mobil lepas kunci maupun dengan sopir.

---

## 🚗 FITUR UTAMA SISTEM

### 1. Sisi Pengunjung & Pelanggan (Frontend Portal)
- **Beranda Interaktif & Modern:** Desain responsif Tailwind CSS dengan pencarian unit cepat berdasarkan kategori, jenis transmisi (Matic / Manual), dan kapasitas kursi.
- **Katalog Armada Lengkap:** Menampilkan foto unit, spesifikasi detail (kapasitas kursi, BBM, tahun pembuatan, plat nomor), ulasan & rating bintang penyewa sebelumnya.
- **Formulir Booking Cepat:**
  - Pilihan lepas kunci vs paket sopir harian.
  - Estimasi kalkulasi otomatis total hari & total biaya secara real-time.
  - Upload jaminan identitas (KTP / SIM / Sepeda Motor + STNK).
  - Penentuan lokasi jemput & lokasi pengembalian.
- **Portal 'Sewa Saya':**
  - Invoice digital dengan status pembayaran dan rincian transaksi.
  - Form upload bukti transfer bank / QRIS.
  - Formulir ulasan & rating setelah kendaraan sukses dikembalikan.

### 2. Sisi Administrator & Petugas Lapangan (Control Panel)
- **Dashboard Eksekutif:**
  - Grafik omset bulanan menggunakan Chart.js.
  - Stat box: Total pendapatan, status armada (Siap/Disewa/Bengkel), driver aktif, dan pemesanan pending.
  - Verifikasi cepat bukti transfer yang baru masuk.
- **Manajemen Armada Mobil:**
  - Input, ubah, dan hapus mobil lengkap dengan foto, plat nomor polisi, tarif per hari, dan tarif denda per jam (*overtime*).
  - Manajemen kategori mobil (MPV, SUV, City Car, Luxury VIP, Minibus HiAce).
- **Manajemen Driver / Sopir:**
  - Pencatatan nomor SIM, tarif harian, kontak telepon, dan status sopir (Tersedia / Bertugas / Libur).
- **Transaksi Sewa & Kasir POS:**
  - Pembuatan sewa manual via kasir untuk pelanggan offline/walk-in.
  - Pengubahan status transaksi: `menunggu_konfirmasi`, `dikonfirmasi`, `sedang_berjalan`, `selesai`, `dibatalkan`.
  - **Fitur Cetak Surat Perjanjian Sewa (Kontrak):** Format siap cetak (*print-friendly*) lengkap dengan kop surat perusahaan, data pihak pertama, pihak kedua, serta pasal ketentuan sewa.
- **Inspeksi Pengembalian & Kalkulasi Denda Otomatis:**
  - Input jam pengembalian aktual dengan deteksi otomatis keterlambatan (*delay hours*).
  - Perhitungan denda telat otomatis sesuai tarif per jam mobil.
  - Pencatatan denda kerusakan body / lecet, denda BBM berkurang, dan upload foto bukti kondisi fisik mobil saat dikembalikan.
- **Verifikasi Pembayaran:**
  - Tinjau preview foto struk transfer pelanggan dengan opsi 'Terima & Validasi' atau 'Tolak'.
  - Saldo kekurangan (*remaining balance*) ter-update secara otomatis begitu pembayaran disetujui.
- **Servis & Perawatan Kendaraan (Maintenance):**
  - Buku riwayat servis rutin mobil (ganti oli, tune up, ganti ban, cuci).
  - Pencatatan biaya bengkel untuk rekonsiliasi pengeluaran.
- **Laporan Rekapitulasi Laba Rugi:**
  - Filter rentang tanggal fleksibel.
  - Perhitungan Pendapatan Bersih: `(Penerimaan Sewa + Denda Masuk) - Biaya Servis Mobil`.
  - Fitur cetak Laporan Resmi pengesahan direktur / owner.
- **Manajemen Pengguna (User Management):**
  - Pengaturan peran: `admin`, `petugas`, dan `pelanggan`.
- **Pengaturan Usaha (Settings):**
  - Nama perusahaan, kontak WhatsApp, rekening bank BCA/Mandiri, alamat garasi, dan pasal syarat sewa.

---

## 🔑 AKUN DEMO SIAP PAKAI

Aplikasi telah dilengkapi seeder data awal yang realistis:

| Peran (Role) | Email | Password | Hak Akses |
|---|---|---|---|
| **Administrator** | `admin@pkd.com` | `admin123` | Akses penuh ke seluruh fitur dan pengaturan |
| **Petugas Lapangan** | `petugas@pkd.com` | `petugas123` | Operasional armada, sewa, dan pengembalian unit |
| **Pelanggan 1** | `pelanggan@pkd.com` | `pelanggan123` | Sewa online, upload transfer, dan ulasan |
| **Pelanggan 2** | `siti@pkd.com` | `pelanggan123` | Simulasi transaksi kedua |

---

## 🛠️ PANDUAN INSTALASI & MENJALANKAN DI SERVER LOKAL

### Persyaratan Sistem
1. PHP versi 8.2 atau lebih tinggi.
2. MySQL Server (XAMPP / Laragon / MariaDB).
3. Composer terinstall di PATH.

### Langkah-langkah
1. Masuk ke direktori proyek:
   ```bash
   cd E:\aplikasiweb\PKD-rentalmobil
   ```

2. Konfigurasi file `.env`:
   Pastikan pengaturan koneksi database MySQL sudah benar:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pkd_rentalmobil
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```

4. Pastikan storage link telah aktif:
   ```bash
   php artisan storage:link
   ```

5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
   Buka peramban (browser) di alamat: **`http://localhost:8000`** atau URL Virtual Host Laragon Anda.

---

## 📂 STRUKTUR DIREKTORI PROYEK

- `app/Http/Controllers/`: Logika sistem untuk public web, auth, pelanggan, dan panel admin.
- `app/Models/`: Model Eloquent relasi antar tabel (User, Car, CarCategory, Driver, Rental, RentalReturn, Payment, CarMaintenance, Review, Setting).
- `database/migrations/`: Seluruh skema database MySQL.
- `database/seeders/`: Data awal mobil, supir, transaksi demo, dan ulasan.
- `resources/views/`: Antarmuka Blade modern berbasis Tailwind CSS.
- `DOKUMENTASI/`: Berisi panduan lengkap sistem dan dokumentasi komersial.

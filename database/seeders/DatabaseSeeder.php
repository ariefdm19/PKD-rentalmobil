<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\RentalReturn;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Settings Toko / Perusahaan Rental
        $settings = [
            'company_name' => 'PKD Rental Mobil',
            'company_tagline' => 'Solusi Sewa Mobil Terpercaya, Murah, dan Aman',
            'company_phone' => '0812-3456-7890',
            'company_whatsapp' => '6281234567890',
            'company_email' => 'admin@rentalmobil.pkd',
            'company_address' => 'Jl. Merdeka No. 88, Bandung, Jawa Barat',
            'bank_name' => 'BCA',
            'bank_account_number' => '8730129841',
            'bank_account_holder' => 'PKD Rental Mobil',
            'qris_image' => '',
            'rental_terms' => "1. Menyerahkan KTP asli / SIM A yang masih berlaku sebagai jaminan.\n2. Wajib membayar DP minimal 30% untuk booking unit.\n3. Keterlambatan pengembalian unit dikenakan denda sesuai tarif per jam.\n4. Biaya bahan bakar dan tol ditanggung penyewa (kecuali paket all-in sopir).\n5. Kerusakan body atau mesin akibat kelalaian ditanggung penyewa sesuai estimasi bengkel.",
        ];
        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 2. Users (Admin, Petugas, Pelanggan)
        $admin = User::firstOrCreate(
            ['email' => 'admin@pkd.com'],
            [
                'name' => 'Administrator PKD',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Bandung, Jawa Barat',
                'nik' => '3273012345670001',
                'is_active' => true,
            ]
        );

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@pkd.com'],
            [
                'name' => 'Budi Santoso (Petugas Lapangan)',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'phone' => '081398765432',
                'address' => 'Cimahi, Jawa Barat',
                'nik' => '3273012345670002',
                'is_active' => true,
            ]
        );

        $customer1 = User::firstOrCreate(
            ['email' => 'pelanggan@pkd.com'],
            [
                'name' => 'Rian Pratama',
                'password' => Hash::make('pelanggan123'),
                'role' => 'pelanggan',
                'phone' => '082155667788',
                'address' => 'Jl. Dago Asri No. 12, Bandung',
                'nik' => '3273012345670003',
                'sim_number' => 'SIM-A-987654321',
                'is_active' => true,
            ]
        );

        $customer2 = User::firstOrCreate(
            ['email' => 'siti@pkd.com'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('pelanggan123'),
                'role' => 'pelanggan',
                'phone' => '085712348899',
                'address' => 'Jl. Buah Batu No. 45, Bandung',
                'nik' => '3273012345670004',
                'sim_number' => 'SIM-A-123456789',
                'is_active' => true,
            ]
        );

        // 3. Kategori Mobil
        $catMpv = CarCategory::firstOrCreate(
            ['slug' => 'mpv'],
            ['name' => 'MPV (Mobil Keluarga)', 'description' => 'Mobil keluarga serbaguna, muat banyak penumpang dengan kenyamanan maksimal.']
        );
        $catSuv = CarCategory::firstOrCreate(
            ['slug' => 'suv'],
            ['name' => 'SUV (Sport Utility)', 'description' => 'Tangguh di berbagai medan, bertenaga besar dan berpenampilan gagah.']
        );
        $catCity = CarCategory::firstOrCreate(
            ['slug' => 'city-car'],
            ['name' => 'City Car / Hatchback', 'description' => 'Lincah di jalanan kota yang padat, hemat bahan bakar dan mudah bermanuver.']
        );
        $catLuxury = CarCategory::firstOrCreate(
            ['slug' => 'luxury'],
            ['name' => 'Luxury / Premium VIP', 'description' => 'Kendaraan mewah untuk tamu kehormatan, pesta pernikahan, dan perjalanan bisnis eksekutif.']
        );
        $catMinibus = CarCategory::firstOrCreate(
            ['slug' => 'minibus-hiace'],
            ['name' => 'Minibus & Travel', 'description' => 'Kapasitas rombongan besar hingga 15-19 kursi dengan kenyamanan suspensi travel premium.']
        );

        // 4. Daftar Mobil
        $carsData = [
            [
                'car_category_id' => $catMpv->id,
                'name' => 'Toyota All New Avanza 1.5 G CVT',
                'brand' => 'Toyota',
                'plate_number' => 'D 1452 PKD',
                'year' => 2024,
                'color' => 'Putih Mutiara',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seating_capacity' => 7,
                'price_per_day' => 400000,
                'penalty_per_hour' => 40000,
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80',
                'features' => 'AC Double Blower, Touchscreen Audio, Bluetooth, Airbags, Kamera Parkir, USB Charger Tiap Baris',
                'status' => 'tersedia',
                'description' => 'Mobil sejuta umat dengan kenyamanan generasi terbaru suspensi empuk dan kabin senyap.',
            ],
            [
                'car_category_id' => $catMpv->id,
                'name' => 'Mitsubishi New Xpander Ultimate CVT',
                'brand' => 'Mitsubishi',
                'plate_number' => 'D 1888 PKD',
                'year' => 2024,
                'color' => 'Hitam Metalik',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seating_capacity' => 7,
                'price_per_day' => 450000,
                'penalty_per_hour' => 45000,
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80',
                'features' => 'Wireless Charger, Cruise Control, AC Digital, Audio Premium, Electronic Parking Brake',
                'status' => 'tersedia',
                'description' => 'Desain futuristik gagah dengan suspensi ternyaman di kelasnya serta kabin ekstra lega.',
            ],
            [
                'car_category_id' => $catSuv->id,
                'name' => 'Toyota Fortuner 2.8 GR Sport 4x2',
                'brand' => 'Toyota',
                'plate_number' => 'D 1001 PKD',
                'year' => 2023,
                'color' => 'Hitam Solid',
                'transmission' => 'Automatic',
                'fuel_type' => 'Diesel',
                'seating_capacity' => 7,
                'price_per_day' => 1100000,
                'penalty_per_hour' => 100000,
                'image' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
                'features' => 'T-Intouch, Blind Spot Detection, 360 Camera, Power Backdoor kick sensor, Sunroof',
                'status' => 'tersedia',
                'description' => 'SUV bertenaga monster dengan mesin 2800cc Diesel. Siap melibas tanjakan terjal dan medan pegunungan.',
            ],
            [
                'car_category_id' => $catSuv->id,
                'name' => 'Honda HR-V 1.5 SE CVT',
                'brand' => 'Honda',
                'plate_number' => 'D 1234 PKD',
                'year' => 2024,
                'color' => 'Abu-abu Metalik',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seating_capacity' => 5,
                'price_per_day' => 600000,
                'penalty_per_hour' => 60000,
                'image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=800&q=80',
                'features' => 'Panoramic Glass Roof, Honda Sensing, Apple CarPlay, Android Auto, LED Headlights',
                'status' => 'tersedia',
                'description' => 'Compact SUV stylish dengan atap panoramic dan fitur keselamatan Honda Sensing terdepan.',
            ],
            [
                'car_category_id' => $catCity->id,
                'name' => 'Honda Brio RS CVT',
                'brand' => 'Honda',
                'plate_number' => 'D 1779 PKD',
                'year' => 2024,
                'color' => 'Kuning / Phoenix Yellow',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seating_capacity' => 5,
                'price_per_day' => 320000,
                'penalty_per_hour' => 35000,
                'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=800&q=80',
                'features' => 'Smart Keyless, Audio Steering Switch, Layar Sentuh 7 Inci, Sensor Parkir, Irit BBM',
                'status' => 'tersedia',
                'description' => 'Mobil perkotaan paling lincah dan hemat bensin. Parkir super mudah di gang sempit dan mall padat.',
            ],
            [
                'car_category_id' => $catLuxury->id,
                'name' => 'Toyota Alphard 2.5 G New Generation',
                'brand' => 'Toyota',
                'plate_number' => 'D 888 PKD',
                'year' => 2024,
                'color' => 'Hitam Mewah',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seating_capacity' => 7,
                'price_per_day' => 2500000,
                'penalty_per_hour' => 250000,
                'image' => 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=800&q=80',
                'features' => 'Captain Seats with Ottoman Massage, Double Moonroof, JBL Premium Sound, Ambient Lighting',
                'status' => 'tersedia',
                'description' => 'Simbol kemewahan dan kenyamanan kelas VIP. Ideal untuk tamu kenegaraan, direksi, dan wedding car.',
            ],
            [
                'car_category_id' => $catMinibus->id,
                'name' => 'Toyota HiAce Premio Luxury 14 Seat',
                'brand' => 'Toyota',
                'plate_number' => 'D 7007 PKD',
                'year' => 2023,
                'color' => 'Silver Metalik',
                'transmission' => 'Manual',
                'fuel_type' => 'Diesel',
                'seating_capacity' => 14,
                'price_per_day' => 1300000,
                'penalty_per_hour' => 120000,
                'image' => 'https://images.unsplash.com/photo-1526726538690-5cbf956ae2fd?auto=format&fit=crop&w=800&q=80',
                'features' => 'Reclining Seat, Port USB tiap kursi, AC Ducting per penumpang, TV Karaoke Android',
                'status' => 'tersedia',
                'description' => 'Armada terbaik untuk liburan rombongan keluarga besar, wisata kantor, atau antar jemput bandara.',
            ],
        ];

        foreach ($carsData as $data) {
            Car::firstOrCreate(['plate_number' => $data['plate_number']], $data);
        }

        // 5. Driver / Sopir
        $drivers = [
            [
                'name' => 'Ahmad Suhendar',
                'phone' => '081223344551',
                'sim_number' => 'SIM-B1-48201938',
                'daily_rate' => 150000,
                'status' => 'tersedia',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'notes' => 'Berpengalaman 10 tahun rute Jawa Barat & Jabodetabek. Ramah, sopan, menguasai jalan alternatif.',
            ],
            [
                'name' => 'Bambang Irawan',
                'phone' => '081223344552',
                'sim_number' => 'SIM-B1-99887766',
                'daily_rate' => 150000,
                'status' => 'tersedia',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
                'notes' => 'Spesialis mobil matic dan VIP Luxury, mahir bahasa Inggris dasar untuk turis asing.',
            ],
            [
                'name' => 'Dedi Kurniawan',
                'phone' => '081223344553',
                'sim_number' => 'SIM-B1-55443322',
                'daily_rate' => 175000,
                'status' => 'tersedia',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=300&q=80',
                'notes' => 'Driver minibus HiAce dan bus pariwisata berlisensi. Paham rute wisata Bandung-Ciwidey-Lembang.',
            ],
        ];
        foreach ($drivers as $drv) {
            Driver::firstOrCreate(['sim_number' => $drv['sim_number']], $drv);
        }

        // 6. Transaksi Rental Contoh (Untuk Demo Langsung & Statistik Dashboard)
        $avanza = Car::where('plate_number', 'D 1452 PKD')->first();
        $xpander = Car::where('plate_number', 'D 1888 PKD')->first();
        $driver1 = Driver::first();

        // Rental 1: Selesai & Dikembalikan
        $rental1 = Rental::firstOrCreate(
            ['rental_code' => 'PKD-RN-20261001-0001'],
            [
                'user_id' => $customer1->id,
                'car_id' => $avanza->id,
                'driver_id' => null,
                'start_date' => Carbon::now()->subDays(6)->setTime(9, 0),
                'end_date' => Carbon::now()->subDays(4)->setTime(9, 0),
                'total_days' => 2,
                'car_cost' => 800000,
                'driver_cost' => 0,
                'discount_amount' => 0,
                'total_amount' => 800000,
                'down_payment' => 300000,
                'remaining_balance' => 0,
                'guarantee_type' => 'KTP Asli',
                'pickup_location' => 'Kantor PKD Rental Mobil',
                'dropoff_location' => 'Kantor PKD Rental Mobil',
                'status' => 'selesai',
            ]
        );

        Payment::firstOrCreate(
            ['payment_code' => 'PKD-PAY-20261001-0001'],
            [
                'rental_id' => $rental1->id,
                'type' => 'dp',
                'amount' => 300000,
                'method' => 'transfer_bank',
                'status' => 'diterima',
                'paid_at' => Carbon::now()->subDays(6)->setTime(8, 30),
                'notes' => 'DP Booking 30%',
            ]
        );

        Payment::firstOrCreate(
            ['payment_code' => 'PKD-PAY-20261004-0002'],
            [
                'rental_id' => $rental1->id,
                'type' => 'pelunasan',
                'amount' => 500000,
                'method' => 'qris',
                'status' => 'diterima',
                'paid_at' => Carbon::now()->subDays(4)->setTime(9, 15),
                'notes' => 'Pelunasan unit saat kembali',
            ]
        );

        RentalReturn::firstOrCreate(
            ['rental_id' => $rental1->id],
            [
                'inspector_id' => $petugas->id,
                'actual_return_date' => Carbon::now()->subDays(4)->setTime(9, 10),
                'delay_hours' => 0,
                'delay_penalty' => 0,
                'damage_penalty' => 0,
                'fuel_penalty' => 0,
                'other_penalty' => 0,
                'total_penalty' => 0,
                'fuel_level_return' => 'Penuh',
                'condition_status' => 'sangat_baik',
                'condition_notes' => 'Kondisi kendaraan sangat bersih, bensin full, tidak ada lecet baru.',
                'payment_status' => 'lunas',
            ]
        );

        Review::firstOrCreate(
            ['rental_id' => $rental1->id],
            [
                'user_id' => $customer1->id,
                'car_id' => $avanza->id,
                'rating' => 5,
                'comment' => 'Pelayanan luar biasa cepat, mobil sangat bersih dan wangi. Recomended banget untuk jalan-jalan di Bandung!',
                'is_published' => true,
            ]
        );

        // Rental 2: Sedang Berjalan (Aktif)
        $rental2 = Rental::firstOrCreate(
            ['rental_code' => 'PKD-RN-20261012-0002'],
            [
                'user_id' => $customer2->id,
                'car_id' => $xpander->id,
                'driver_id' => $driver1->id,
                'start_date' => Carbon::now()->subDay()->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(2)->setTime(10, 0),
                'total_days' => 3,
                'car_cost' => 1350000,
                'driver_cost' => 450000,
                'discount_amount' => 50000,
                'total_amount' => 1750000,
                'down_payment' => 1000000,
                'remaining_balance' => 750000,
                'guarantee_type' => 'SIM A & Kartu Keluarga',
                'pickup_location' => 'Hotel Arya Duta Bandung',
                'dropoff_location' => 'Stasiun Kereta Cepat Tegalluar',
                'status' => 'sedang_berjalan',
            ]
        );

        Payment::firstOrCreate(
            ['payment_code' => 'PKD-PAY-20261012-0003'],
            [
                'rental_id' => $rental2->id,
                'type' => 'dp',
                'amount' => 1000000,
                'method' => 'transfer_bank',
                'status' => 'diterima',
                'paid_at' => Carbon::now()->subDay()->setTime(8, 0),
                'notes' => 'Pembayaran DP sewa plus sopir',
            ]
        );

        $xpander->update(['status' => 'disewa']);
        $driver1->update(['status' => 'bertugas']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\RentalReturn;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SystemWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $petugas;
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();
        // Jalankan seeder lengkap agar seluruh relasi dan setting siap
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::where('role', 'admin')->first();
        $this->petugas = User::where('role', 'petugas')->first();
        $this->customer = User::where('role', 'pelanggan')->first();
    }

    /**
     * 1. Test Menu Publik & Frontend
     */
    public function test_public_pages_load_successfully(): void
    {
        // Beranda
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('PKD Rental Mobil');

        // Filter beranda
        $response = $this->get(route('home', ['category' => 'mpv', 'transmission' => 'Automatic']));
        $response->assertStatus(200);

        // Katalog Mobil
        $response = $this->get(route('cars.catalog'));
        $response->assertStatus(200);
        $response->assertSee('Katalog Armada');

        // Detail Mobil
        $car = Car::first();
        $response = $this->get(route('cars.detail', $car->id));
        $response->assertStatus(200);
        $response->assertSee($car->name);

        // Halaman Login & Register
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang');

        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Baru');
    }

    /**
     * 2. Test Alur Autentikasi (Register, Login, Logout)
     */
    public function test_auth_workflow(): void
    {
        // Register user baru
        $response = $this->post(route('register.post'), [
            'name' => 'Testing Pelanggan',
            'email' => 'newpelanggan@pkd.com',
            'phone' => '089911223344',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'address' => 'Bandung Timur',
        ]);
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => 'newpelanggan@pkd.com']);

        // Logout
        $response = $this->post(route('logout'));
        $response->assertRedirect(route('home'));

        // Login kembali
        $response = $this->post(route('login.post'), [
            'email' => 'newpelanggan@pkd.com',
            'password' => 'secret123',
        ]);
        $response->assertRedirect(route('customer.rentals.index'));
    }

    /**
     * 3. Test Alur Pelanggan (Booking, Upload Bayar, Ulasan)
     */
    public function test_customer_booking_and_payment_workflow(): void
    {
        Storage::fake('public');
        $car = Car::where('status', 'tersedia')->first();

        // 1. Buka form booking
        $response = $this->actingAs($this->customer)->get(route('rentals.booking', $car->id));
        $response->assertStatus(200);

        // 2. Submit booking sewa
        $startDate = now()->addDay()->setTime(9, 0)->format('Y-m-d\TH:i');
        $endDate = now()->addDays(3)->setTime(9, 0)->format('Y-m-d\TH:i');

        $response = $this->actingAs($this->customer)->post(route('rentals.booking.post', $car->id), [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'driver_id' => '',
            'guarantee_type' => 'KTP Asli',
            'pickup_location' => 'Kantor PKD Rental',
            'dropoff_location' => 'Kantor PKD Rental',
            'notes' => 'Tolong mobil dicuci bersih',
        ]);

        $rental = Rental::where('user_id', $this->customer->id)->orderByDesc('id')->first();
        $this->assertNotNull($rental);
        $response->assertRedirect(route('customer.rentals.show', $rental->id));

        // 3. Lihat invoice sewa saya
        $response = $this->actingAs($this->customer)->get(route('customer.rentals.index'));
        $response->assertStatus(200);
        $response->assertSee($rental->rental_code);

        $response = $this->actingAs($this->customer)->get(route('customer.rentals.show', $rental->id));
        $response->assertStatus(200);
        $response->assertSee($rental->rental_code);

        // 4. Upload bukti pembayaran DP
        $file = UploadedFile::fake()->image('bukti_transfer.jpg');
        $response = $this->actingAs($this->customer)->post(route('customer.rentals.payment', $rental->id), [
            'type' => 'dp',
            'amount' => 300000,
            'method' => 'transfer_bank',
            'proof_file' => $file,
            'notes' => 'Sudah ditransfer ke BCA',
        ]);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('payments', [
            'rental_id' => $rental->id,
            'amount' => 300000,
            'status' => 'menunggu_konfirmasi',
        ]);
    }

    /**
     * 4. Test Seluruh Menu Admin Panel
     */
    public function test_admin_menus_accessibility(): void
    {
        // 1. Dashboard
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Ringkasan Operasional & Keuangan');

        // 2. Kategori Mobil
        $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));
        $response->assertStatus(200);

        // Buat Kategori Baru
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Sedan Mewah Baru',
            'description' => 'Khusus VIP',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('car_categories', ['name' => 'Sedan Mewah Baru']);

        // 3. Armada Mobil (Index, Create, Store, Edit, Update)
        $response = $this->actingAs($this->admin)->get(route('admin.cars.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('admin.cars.create'));
        $response->assertStatus(200);

        $cat = CarCategory::first();
        $response = $this->actingAs($this->admin)->post(route('admin.cars.store'), [
            'car_category_id' => $cat->id,
            'name' => 'Hyundai Stargazer X Prime',
            'brand' => 'Hyundai',
            'plate_number' => 'D 9999 PKD',
            'year' => 2024,
            'transmission' => 'Automatic',
            'fuel_type' => 'Bensin',
            'seating_capacity' => 7,
            'price_per_day' => 450000,
            'penalty_per_hour' => 45000,
            'status' => 'tersedia',
        ]);
        $response->assertRedirect(route('admin.cars.index'));
        $newCar = Car::where('plate_number', 'D 9999 PKD')->first();
        $this->assertNotNull($newCar);

        $response = $this->actingAs($this->admin)->get(route('admin.cars.edit', $newCar->id));
        $response->assertStatus(200);

        // 4. Sopir / Driver (Index, Create, Store, Edit)
        $response = $this->actingAs($this->admin)->get(route('admin.drivers.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('admin.drivers.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->post(route('admin.drivers.store'), [
            'name' => 'Yudi Hendrawan',
            'phone' => '081299887711',
            'sim_number' => 'SIM-B1-77889900',
            'daily_rate' => 160000,
            'status' => 'tersedia',
            'notes' => 'Siap luar kota Jawa-Bali',
        ]);
        $response->assertRedirect(route('admin.drivers.index'));
        $this->assertDatabaseHas('drivers', ['sim_number' => 'SIM-B1-77889900']);

        // 5. Transaksi Sewa (Index, Create Kasir, Show, Status, Cetak Kontrak)
        $response = $this->actingAs($this->admin)->get(route('admin.rentals.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('admin.rentals.create'));
        $response->assertStatus(200);

        $rental = Rental::first();
        $response = $this->actingAs($this->admin)->get(route('admin.rentals.show', $rental->id));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('admin.rentals.print', $rental->id));
        $response->assertStatus(200);
        $response->assertSee('Surat Perjanjian Sewa');

        // Ubah Status Rental
        $response = $this->actingAs($this->admin)->post(route('admin.rentals.status', $rental->id), [
            'status' => 'dikonfirmasi',
        ]);
        $response->assertStatus(302);

        // 6. Pengembalian & Denda (Index, Create, Store, Show)
        $response = $this->actingAs($this->admin)->get(route('admin.returns.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('admin.returns.create', ['rental_id' => $rental->id]));
        $response->assertStatus(200);

        $returnRecord = RentalReturn::first();
        if ($returnRecord) {
            $response = $this->actingAs($this->admin)->get(route('admin.returns.show', $returnRecord->id));
            $response->assertStatus(200);
        }

        // 7. Verifikasi Pembayaran (Index, Show, Acc Status)
        $response = $this->actingAs($this->admin)->get(route('admin.payments.index'));
        $response->assertStatus(200);

        $payment = Payment::first();
        $response = $this->actingAs($this->admin)->get(route('admin.payments.show', $payment->id));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->post(route('admin.payments.status', $payment->id), [
            'status' => 'diterima',
            'notes' => 'Dana telah masuk ke rekening BCA',
        ]);
        $response->assertStatus(302);

        // 8. Servis & Perawatan Kendaraan (Index, Create, Store)
        $response = $this->actingAs($this->admin)->get(route('admin.maintenances.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('admin.maintenances.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->post(route('admin.maintenances.store'), [
            'car_id' => $newCar->id,
            'service_type' => 'Ganti Oli Mesin & Filter',
            'maintenance_date' => now()->toDateString(),
            'cost' => 450000,
            'workshop_name' => 'Auto2000 Pasteur',
            'description' => 'Servis berkala 10.000 KM',
        ]);
        $response->assertRedirect(route('admin.maintenances.index'));
        $this->assertDatabaseHas('car_maintenances', ['service_type' => 'Ganti Oli Mesin & Filter']);

        // 9. Laporan Laba Rugi (Index, Print)
        $response = $this->actingAs($this->admin)->get(route('admin.reports.index'));
        $response->assertStatus(200);
        $response->assertSee('Laporan Keuangan & Kinerja Bisnis Rental');

        $response = $this->actingAs($this->admin)->get(route('admin.reports.print'));
        $response->assertStatus(200);
        $response->assertSee('LAPORAN REKAPITULASI LABA RUGI OPERASIONAL');

        // 10. Manajemen Pengguna (Index, Create, Store, Edit)
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get(route('admin.users.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name' => 'Staff Baru Kasir',
            'email' => 'staffkasir@pkd.com',
            'phone' => '087788990011',
            'role' => 'petugas',
            'password' => 'staff123',
        ]);
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'staffkasir@pkd.com']);

        // 11. Pengaturan Usaha (Index, Update)
        $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil & Rekening Rental');

        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'company_name' => 'PKD Rental Mobil Juara',
            'company_tagline' => 'Sewa Mudah Terpercaya',
            'company_phone' => '0812-3456-7890',
            'company_whatsapp' => '6281234567890',
            'company_email' => 'admin@rentalmobil.pkd',
            'bank_name' => 'BCA',
            'bank_account_number' => '8730129841',
            'bank_account_holder' => 'PKD Rental Mobil',
            'rental_terms' => '1. KTP Asli wajib.\n2. Rawat unit dengan baik.',
        ]);
        $response->assertSessionHas('success');
        $this->assertEquals('PKD Rental Mobil Juara', Setting::get('company_name'));
    }

    /**
     * 5. Test Hak Akses (Role Protection)
     */
    public function test_role_access_protection(): void
    {
        // Pelanggan tidak boleh membuka panel admin (harus 403)
        $response = $this->actingAs($this->customer)->get(route('admin.dashboard'));
        $response->assertStatus(403);

        // Guest tanpa login diarahkan ke login
        auth()->logout();
        $this->flushSession();
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));

        // Petugas lapangan bisa buka dashboard tapi tidak bisa buka manajemen user
        $response = $this->actingAs($this->petugas)->get(route('admin.dashboard'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->petugas)->get(route('admin.users.index'));
        $response->assertStatus(403);
    }
}

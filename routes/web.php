<?php

use App\Http\Controllers\Admin\CarCategoryController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CarMaintenanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RentalManagementController;
use App\Http\Controllers\Admin\RentalReturnController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

// Public / Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [HomeController::class, 'catalog'])->name('cars.catalog');
Route::get('/mobil/{id}', [HomeController::class, 'carDetail'])->name('cars.detail');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer / Pelanggan Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/sewa/{id}', [RentalController::class, 'bookingForm'])->name('rentals.booking');
    Route::post('/sewa/{id}', [RentalController::class, 'processBooking'])->name('rentals.booking.post');
    Route::get('/riwayat-sewa', [RentalController::class, 'customerRentals'])->name('customer.rentals.index');
    Route::get('/riwayat-sewa/{id}', [RentalController::class, 'showRental'])->name('customer.rentals.show');
    Route::post('/riwayat-sewa/{id}/pembayaran', [RentalController::class, 'uploadPayment'])->name('customer.rentals.payment');
    Route::post('/riwayat-sewa/{id}/ulasan', [RentalController::class, 'storeReview'])->name('customer.rentals.review');
});

// Admin & Petugas Panel Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Kategori Mobil
    Route::resource('categories', CarCategoryController::class)->except(['create', 'show', 'edit']);

    // Manajemen Mobil
    Route::resource('cars', CarController::class);

    // Manajemen Sopir / Driver
    Route::resource('drivers', DriverController::class);

    // Transaksi Rental
    Route::get('/rentals', [RentalManagementController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create', [RentalManagementController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [RentalManagementController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{id}', [RentalManagementController::class, 'show'])->name('rentals.show');
    Route::post('/rentals/{id}/status', [RentalManagementController::class, 'updateStatus'])->name('rentals.status');
    Route::get('/rentals/{id}/cetak-kontrak', [RentalManagementController::class, 'printContract'])->name('rentals.print');

    // Pengembalian Unit & Inspeksi Denda
    Route::get('/returns', [RentalReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/create', [RentalReturnController::class, 'create'])->name('returns.create');
    Route::post('/returns', [RentalReturnController::class, 'store'])->name('returns.store');
    Route::get('/returns/{id}', [RentalReturnController::class, 'show'])->name('returns.show');

    // Verifikasi Pembayaran
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{id}/status', [PaymentController::class, 'updateStatus'])->name('payments.status');

    // Perawatan Mobil (Service & Maintenance)
    Route::get('/maintenances', [CarMaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('/maintenances/create', [CarMaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('/maintenances', [CarMaintenanceController::class, 'store'])->name('maintenances.store');
    Route::delete('/maintenances/{id}', [CarMaintenanceController::class, 'destroy'])->name('maintenances.destroy');

    // Laporan Keuangan & Sewa
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');

    // Khusus Admin Utama
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

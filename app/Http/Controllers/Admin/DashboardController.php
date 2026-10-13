<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\RentalReturn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCars = Car::count();
        $carsAvailable = Car::where('status', 'tersedia')->count();
        $carsRented = Car::where('status', 'disewa')->count();
        $carsMaintenance = Car::where('status', 'perawatan')->count();

        $totalCustomers = User::where('role', 'pelanggan')->count();
        $totalDrivers = Driver::count();
        $driversAvailable = Driver::where('status', 'tersedia')->count();

        $rentalsPending = Rental::where('status', 'menunggu_konfirmasi')->count();
        $rentalsActive = Rental::where('status', 'sedang_berjalan')->count();
        $rentalsCompleted = Rental::where('status', 'selesai')->count();

        $totalRevenue = Payment::where('status', 'diterima')->sum('amount');
        $monthRevenue = Payment::where('status', 'diterima')
            ->whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->sum('amount');

        $penaltiesTotal = RentalReturn::sum('total_penalty');

        $recentRentals = Rental::with(['user', 'car', 'driver'])
            ->latest()
            ->take(5)
            ->get();

        $pendingPayments = Payment::with(['rental.user', 'rental.car'])
            ->where('status', 'menunggu_konfirmasi')
            ->latest()
            ->take(5)
            ->get();

        // Chart data per bulan tahun berjalan
        $chartMonths = [];
        $chartIncome = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthDate = Carbon::create(Carbon::now()->year, $m, 1);
            $chartMonths[] = $monthDate->translatedFormat('M');
            $income = Payment::where('status', 'diterima')
                ->whereMonth('paid_at', $m)
                ->whereYear('paid_at', Carbon::now()->year)
                ->sum('amount');
            $chartIncome[] = (float) $income;
        }

        return view('admin.dashboard', compact(
            'totalCars',
            'carsAvailable',
            'carsRented',
            'carsMaintenance',
            'totalCustomers',
            'totalDrivers',
            'driversAvailable',
            'rentalsPending',
            'rentalsActive',
            'rentalsCompleted',
            'totalRevenue',
            'monthRevenue',
            'penaltiesTotal',
            'recentRentals',
            'pendingPayments',
            'chartMonths',
            'chartIncome'
        ));
    }
}

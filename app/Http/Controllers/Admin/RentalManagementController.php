<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Rental;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RentalManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['user', 'car', 'driver', 'payments', 'returnRecord']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('rental_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('car', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('plate_number', 'like', "%{$search}%");
                  });
            });
        }

        $rentals = $query->latest()->paginate(10)->withQueryString();

        return view('admin.rentals.index', compact('rentals'));
    }

    public function create()
    {
        $cars = Car::where('status', 'tersedia')->get();
        $drivers = Driver::where('status', 'tersedia')->get();
        $customers = User::where('role', 'pelanggan')->orderBy('name')->get();

        return view('admin.rentals.create', compact('cars', 'drivers', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'car_id' => ['required', 'exists:cars,id'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'down_payment' => ['nullable', 'numeric', 'min:0'],
            'guarantee_type' => ['required', 'string'],
            'pickup_location' => ['required', 'string'],
            'dropoff_location' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:menunggu_konfirmasi,dikonfirmasi,sedang_berjalan,selesai,dibatalkan'],
        ]);

        $car = Car::findOrFail($validated['car_id']);
        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $totalDays = max(1, (int) ceil($start->floatDiffInDays($end)));

        $carCost = $car->price_per_day * $totalDays;
        $driverCost = 0;

        if (!empty($validated['driver_id'])) {
            $driver = Driver::find($validated['driver_id']);
            if ($driver) {
                $driverCost = $driver->daily_rate * $totalDays;
            }
        }

        $discount = $validated['discount_amount'] ?? 0;
        $totalAmount = max(0, ($carCost + $driverCost) - $discount);
        $downPayment = $validated['down_payment'] ?? 0;
        $remaining = max(0, $totalAmount - $downPayment);

        $rentalCode = 'PKD-RN-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $rental = Rental::create([
            'rental_code' => $rentalCode,
            'user_id' => $validated['user_id'],
            'car_id' => $car->id,
            'driver_id' => $validated['driver_id'] ?? null,
            'start_date' => $start,
            'end_date' => $end,
            'total_days' => $totalDays,
            'car_cost' => $carCost,
            'driver_cost' => $driverCost,
            'discount_amount' => $discount,
            'total_amount' => $totalAmount,
            'down_payment' => $downPayment,
            'remaining_balance' => $remaining,
            'guarantee_type' => $validated['guarantee_type'],
            'pickup_location' => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'notes' => $validated['notes'] ?? null,
            'status' => $validated['status'],
        ]);

        if (in_array($validated['status'], ['dikonfirmasi', 'sedang_berjalan'])) {
            $car->update(['status' => 'disewa']);
            if (!empty($validated['driver_id'])) {
                Driver::where('id', $validated['driver_id'])->update(['status' => 'bertugas']);
            }
        }

        return redirect()->route('admin.rentals.show', $rental->id)->with('success', 'Transaksi rental baru berhasil dibuat!');
    }

    public function show($id)
    {
        $rental = Rental::with(['user', 'car.category', 'driver', 'payments', 'returnRecord.inspector'])->findOrFail($id);
        $companyName = Setting::get('company_name', 'PKD Rental Mobil');

        return view('admin.rentals.show', compact('rental', 'companyName'));
    }

    public function updateStatus(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:menunggu_konfirmasi,dikonfirmasi,sedang_berjalan,selesai,dibatalkan'],
        ]);

        $prevStatus = $rental->status;
        $newStatus = $validated['status'];

        $rental->update(['status' => $newStatus]);

        // Sesuaikan status unit mobil dan sopir
        if ($newStatus === 'sedang_berjalan' || $newStatus === 'dikonfirmasi') {
            $rental->car->update(['status' => 'disewa']);
            if ($rental->driver) {
                $rental->driver->update(['status' => 'bertugas']);
            }
        } elseif ($newStatus === 'selesai' || $newStatus === 'dibatalkan') {
            $rental->car->update(['status' => 'tersedia']);
            if ($rental->driver) {
                $rental->driver->update(['status' => 'tersedia']);
            }
        }

        return back()->with('success', 'Status transaksi berhasil diubah menjadi: ' . ucfirst(str_replace('_', ' ', $newStatus)));
    }

    public function printContract($id)
    {
        $rental = Rental::with(['user', 'car.category', 'driver', 'payments', 'returnRecord'])->findOrFail($id);
        $settings = [
            'company_name' => Setting::get('company_name', 'PKD Rental Mobil'),
            'company_phone' => Setting::get('company_phone', '0812-3456-7890'),
            'company_address' => Setting::get('company_address', 'Bandung, Jawa Barat'),
            'company_email' => Setting::get('company_email', 'admin@rentalmobil.pkd'),
            'rental_terms' => Setting::get('rental_terms', ''),
        ];

        return view('admin.rentals.contract', compact('rental', 'settings'));
    }
}

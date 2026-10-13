<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\Review;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RentalController extends Controller
{
    public function bookingForm($carId)
    {
        $car = Car::findOrFail($carId);

        if ($car->status !== 'tersedia') {
            return redirect()->route('cars.detail', $car->id)->with('error', 'Maaf, unit mobil ini saat ini sedang ' . $car->status . '. Silakan pilih unit lain.');
        }

        $drivers = Driver::where('status', 'tersedia')->get();
        $user = Auth::user();
        $terms = Setting::get('rental_terms', '');

        return view('rentals.booking', compact('car', 'drivers', 'user', 'terms'));
    }

    public function processBooking(Request $request, $carId)
    {
        $car = Car::findOrFail($carId);

        if ($car->status !== 'tersedia') {
            return redirect()->route('cars.detail', $car->id)->with('error', 'Mobil tidak sedang tersedia.');
        }

        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'guarantee_type' => ['required', 'string'],
            'guarantee_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'pickup_location' => ['required', 'string'],
            'dropoff_location' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ], [
            'start_date.required' => 'Tanggal mulai sewa harus diisi.',
            'start_date.after_or_equal' => 'Tanggal mulai sewa minimal hari ini.',
            'end_date.required' => 'Tanggal selesai sewa harus diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai sewa.',
            'guarantee_type.required' => 'Pilih jenis jaminan identitas.',
            'pickup_location.required' => 'Lokasi penjemputan harus diisi.',
            'dropoff_location.required' => 'Lokasi pengembalian harus diisi.',
        ]);

        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $totalDays = max(1, (int) ceil($start->floatDiffInDays($end)));

        $carCost = $car->price_per_day * $totalDays;
        $driverCost = 0;
        $driver = null;

        if (!empty($validated['driver_id'])) {
            $driver = Driver::find($validated['driver_id']);
            if ($driver && $driver->status === 'tersedia') {
                $driverCost = $driver->daily_rate * $totalDays;
            }
        }

        $totalAmount = $carCost + $driverCost;
        $downPayment = round($totalAmount * 0.3); // Rekomendasi DP 30%
        $remainingBalance = $totalAmount;

        // Upload berkas jaminan jika ada
        $guaranteePath = null;
        if ($request->hasFile('guarantee_file')) {
            $guaranteePath = $request->file('guarantee_file')->store('guarantees', 'public');
        }

        // Generate rental code
        $rentalCode = 'PKD-RN-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $rental = Rental::create([
            'rental_code' => $rentalCode,
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'driver_id' => $driver ? $driver->id : null,
            'start_date' => $start,
            'end_date' => $end,
            'total_days' => $totalDays,
            'car_cost' => $carCost,
            'driver_cost' => $driverCost,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,
            'down_payment' => $downPayment,
            'remaining_balance' => $remainingBalance,
            'guarantee_type' => $validated['guarantee_type'],
            'guarantee_file' => $guaranteePath,
            'pickup_location' => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'menunggu_konfirmasi',
        ]);

        return redirect()->route('customer.rentals.show', $rental->id)->with('success', 'Booking berhasil diajukan! Silakan upload bukti pembayaran DP atau pelunasan.');
    }

    public function customerRentals()
    {
        $rentals = Rental::with(['car', 'driver', 'payments'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.rentals.index', compact('rentals'));
    }

    public function showRental($id)
    {
        $rental = Rental::with(['car.category', 'driver', 'payments', 'returnRecord', 'review'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $bankInfo = [
            'name' => Setting::get('bank_name', 'BCA'),
            'account' => Setting::get('bank_account_number', '8730129841'),
            'holder' => Setting::get('bank_account_holder', 'PKD Rental Mobil'),
            'whatsapp' => Setting::get('company_whatsapp', '6281234567890'),
        ];

        return view('customer.rentals.show', compact('rental', 'bankInfo'));
    }

    public function uploadPayment(Request $request, $rentalId)
    {
        $rental = Rental::where('user_id', Auth::id())->findOrFail($rentalId);

        $validated = $request->validate([
            'type' => ['required', 'in:dp,pelunasan,pembayaran_penuh'],
            'amount' => ['required', 'numeric', 'min:10000'],
            'method' => ['required', 'in:transfer_bank,qris,tunai'],
            'proof_file' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'notes' => ['nullable', 'string'],
        ], [
            'amount.required' => 'Nominal pembayaran harus diisi.',
            'proof_file.required' => 'Upload bukti transfer wajib disertakan.',
            'proof_file.image' => 'File bukti transfer harus berupa gambar (JPG, PNG).',
        ]);

        $proofPath = $request->file('proof_file')->store('payments', 'public');
        $paymentCode = 'PKD-PAY-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        Payment::create([
            'rental_id' => $rental->id,
            'payment_code' => $paymentCode,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'proof_file' => $proofPath,
            'status' => 'menunggu_konfirmasi',
            'paid_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Tim admin kami akan segera memverifikasinya.');
    }

    public function storeReview(Request $request, $rentalId)
    {
        $rental = Rental::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->findOrFail($rentalId);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            ['rental_id' => $rental->id],
            [
                'user_id' => Auth::id(),
                'car_id' => $rental->car_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'is_published' => true,
            ]
        );

        return back()->with('success', 'Terima kasih atas ulasan dan rating yang Anda berikan!');
    }
}

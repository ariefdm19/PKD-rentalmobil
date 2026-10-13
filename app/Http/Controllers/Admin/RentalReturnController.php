<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\RentalReturn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalReturnController extends Controller
{
    public function index()
    {
        $returns = RentalReturn::with(['rental.car', 'rental.user', 'inspector'])
            ->latest()
            ->paginate(10);

        return view('admin.returns.index', compact('returns'));
    }

    public function create(Request $request)
    {
        $rentalId = $request->rental_id;
        $activeRentals = Rental::with(['user', 'car'])
            ->whereIn('status', ['sedang_berjalan', 'dikonfirmasi'])
            ->get();

        $selectedRental = null;
        if ($rentalId) {
            $selectedRental = Rental::with(['user', 'car', 'driver'])->find($rentalId);
        }

        return view('admin.returns.create', compact('activeRentals', 'selectedRental'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => ['required', 'exists:rentals,id'],
            'actual_return_date' => ['required', 'date'],
            'damage_penalty' => ['nullable', 'numeric', 'min:0'],
            'fuel_penalty' => ['nullable', 'numeric', 'min:0'],
            'other_penalty' => ['nullable', 'numeric', 'min:0'],
            'fuel_level_return' => ['required', 'string'],
            'condition_status' => ['required', 'in:sangat_baik,baik,baret_ringan,rusak_sedang,rusak_berat'],
            'condition_notes' => ['nullable', 'string'],
            'condition_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'payment_status' => ['required', 'in:lunas,belum_lunas'],
        ]);

        $rental = Rental::with('car', 'driver')->findOrFail($validated['rental_id']);

        $actualDate = Carbon::parse($validated['actual_return_date']);
        $scheduledEnd = $rental->end_date;

        $delayHours = 0;
        $delayPenalty = 0;

        if ($actualDate->gt($scheduledEnd)) {
            $delayHours = (int) ceil($actualDate->diffInMinutes($scheduledEnd) / 60);
            $penaltyPerHour = (float) $rental->car->penalty_per_hour;
            $delayPenalty = $delayHours * $penaltyPerHour;
        }

        $damagePenalty = (float) ($validated['damage_penalty'] ?? 0);
        $fuelPenalty = (float) ($validated['fuel_penalty'] ?? 0);
        $otherPenalty = (float) ($validated['other_penalty'] ?? 0);

        $totalPenalty = $delayPenalty + $damagePenalty + $fuelPenalty + $otherPenalty;

        $photoPath = null;
        if ($request->hasFile('condition_photo')) {
            $photoPath = $request->file('condition_photo')->store('returns', 'public');
        }

        $returnRecord = RentalReturn::updateOrCreate(
            ['rental_id' => $rental->id],
            [
                'inspector_id' => Auth::id(),
                'actual_return_date' => $actualDate,
                'delay_hours' => $delayHours,
                'delay_penalty' => $delayPenalty,
                'damage_penalty' => $damagePenalty,
                'fuel_penalty' => $fuelPenalty,
                'other_penalty' => $otherPenalty,
                'total_penalty' => $totalPenalty,
                'fuel_level_return' => $validated['fuel_level_return'],
                'condition_status' => $validated['condition_status'],
                'condition_notes' => $validated['condition_notes'] ?? null,
                'condition_photo' => $photoPath,
                'payment_status' => $validated['payment_status'],
            ]
        );

        // Update status rental & kembalikan mobil & sopir ke status tersedia
        $rental->update(['status' => 'selesai']);
        $rental->car->update(['status' => 'tersedia']);
        if ($rental->driver) {
            $rental->driver->update(['status' => 'tersedia']);
        }

        return redirect()->route('admin.returns.show', $returnRecord->id)->with('success', 'Pemeriksaan pengembalian unit mobil berhasil diproses!');
    }

    public function show($id)
    {
        $return = RentalReturn::with(['rental.car', 'rental.user', 'rental.driver', 'inspector'])->findOrFail($id);
        return view('admin.returns.show', compact('return'));
    }
}

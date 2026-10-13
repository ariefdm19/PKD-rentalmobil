<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['rental.user', 'rental.car']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('payment_code', 'like', "%{$search}%")
                  ->orWhereHas('rental', function ($rq) use ($search) {
                      $rq->where('rental_code', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['rental.user', 'rental.car'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::with('rental')->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:menunggu_konfirmasi,diterima,ditolak'],
            'notes' => ['nullable', 'string'],
        ]);

        $payment->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $payment->notes,
        ]);

        // Jika pembayaran diterima, update remaining balance rental
        if ($validated['status'] === 'diterima') {
            $rental = $payment->rental;
            $totalPaid = $rental->totalPaid();
            $newRemaining = max(0, $rental->total_amount - $totalPaid);
            $rental->update(['remaining_balance' => $newRemaining]);

            // Jika status rental masih menunggu_konfirmasi dan sudah bayar DP/penuh, ubah ke dikonfirmasi
            if ($rental->status === 'menunggu_konfirmasi') {
                $rental->update(['status' => 'dikonfirmasi']);
                $rental->car->update(['status' => 'disewa']);
            }
        }

        return back()->with('success', 'Status verifikasi pembayaran berhasil diupdate!');
    }
}

@extends('layouts.admin')

@section('title', 'Periksa Pembayaran - ' . $payment->payment_code)
@section('page_title', 'Verifikasi Bukti Transfer')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6 text-xs">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-slate-100 gap-4">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kode Pembayaran:</span>
                <h2 class="text-xl font-mono font-black text-blue-600">{{ $payment->payment_code }}</h2>
                <div class="text-slate-500 mt-1">Diajukan pada: {{ $payment->created_at->translatedFormat('d F Y, H:i') }}</div>
            </div>
            <div>
                <span class="px-3 py-1.5 rounded-xl font-bold uppercase text-[11px]
                    @if($payment->status === 'diterima') bg-emerald-50 text-emerald-700 border border-emerald-200
                    @elseif($payment->status === 'menunggu_konfirmasi') bg-amber-50 text-amber-700 border border-amber-200
                    @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                    {{ str_replace('_', ' ', $payment->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <!-- Rincian -->
            <div class="space-y-4">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Penyewa:</span>
                        <span class="font-bold text-slate-900">{{ $payment->rental->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kode Rental:</span>
                        <a href="{{ route('admin.rentals.show', $payment->rental_id) }}" class="font-mono font-bold text-blue-600 hover:underline">{{ $payment->rental->rental_code }}</a>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Unit Mobil:</span>
                        <span class="font-bold text-slate-800">{{ $payment->rental->car->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tipe Pembayaran:</span>
                        <span class="capitalize font-bold text-slate-800">{{ str_replace('_', ' ', $payment->type) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Metode Bayar:</span>
                        <span class="font-semibold text-slate-800 uppercase">{{ str_replace('_', ' ', $payment->method) }}</span>
                    </div>
                    <div class="pt-2 border-t border-slate-200 flex justify-between text-sm font-black">
                        <span class="text-slate-900">Nominal Ditransfer:</span>
                        <span class="text-blue-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Form Update Verifikasi -->
                <form action="{{ route('admin.payments.status', $payment->id) }}" method="POST" class="p-5 bg-white rounded-2xl border border-slate-200 space-y-3">
                    @csrf
                    <h4 class="font-bold text-slate-900 uppercase tracking-wider text-[11px]">Tindakan Verifikasi</h4>
                    <div>
                        <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800">
                            <option value="diterima" {{ $payment->status == 'diterima' ? 'selected' : '' }}>✅ Terima & Validasi (Lunas/DP Masuk)</option>
                            <option value="menunggu_konfirmasi" {{ $payment->status == 'menunggu_konfirmasi' ? 'selected' : '' }}>⏳ Masih Dicek (Pending)</option>
                            <option value="ditolak" {{ $payment->status == 'ditolak' ? 'selected' : '' }}>❌ Tolak Bukti Transfer (Palsu/Tidak Masuk)</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" name="notes" value="{{ $payment->notes }}" placeholder="Catatan ke pelanggan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition">
                        Simpan Keputusan Verifikasi
                    </button>
                </form>
            </div>

            <!-- Foto Struk -->
            <div>
                <span class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Bukti Struk Transfer / QRIS:</span>
                @if($payment->proof_file)
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <img src="{{ asset('storage/' . $payment->proof_file) }}" alt="Bukti Transfer" class="w-full h-80 object-contain bg-slate-900">
                        <div class="p-3 bg-slate-50 text-center border-t border-slate-100">
                            <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" class="text-blue-600 font-bold hover:underline">
                                <i class="fa-solid fa-up-right-and-down-left-from-center mr-1"></i> Buka Ukuran Asli
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-8 bg-slate-50 rounded-2xl border border-dashed border-slate-300 text-center text-slate-400">
                        <i class="fa-solid fa-file-invoice-dollar text-3xl mb-2"></i>
                        <p>Pembayaran tunai / tidak ada lampiran struk transfer.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pembayaran
            </a>
        </div>
    </div>
</div>
@endsection

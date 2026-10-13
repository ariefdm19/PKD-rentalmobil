@extends('layouts.app')

@section('title', 'Riwayat Sewa Saya - PKD Rental Mobil')

@section('content')
<div class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Riwayat Pemesanan & Sewa Mobil</h1>
        <p class="text-slate-400 text-xs mt-1">Pantau status transaksi sewa, jadwal pengambilan, dan bukti pembayaran Anda.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-extrabold text-slate-900 text-base">Daftar Transaksi Saya</h3>
            <a href="{{ route('cars.catalog') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-plus"></i> Sewa Mobil Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Kode Booking</th>
                        <th class="py-4 px-6">Armada Mobil</th>
                        <th class="py-4 px-6">Durasi & Tanggal</th>
                        <th class="py-4 px-6">Total Biaya</th>
                        <th class="py-4 px-6">Status Rental</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rentals as $rental)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                {{ $rental->rental_code }}
                                <span class="block text-[10px] text-slate-400 font-sans font-normal">{{ $rental->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $rental->car->name }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $rental->car->plate_number }} &bull; {{ $rental->driver ? 'Plus Driver: ' . $rental->driver->name : 'Lepas Kunci' }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <div><span class="font-semibold text-slate-800">{{ $rental->start_date->translatedFormat('d M Y H:i') }}</span></div>
                                <div class="text-[11px] text-slate-400">s/d {{ $rental->end_date->translatedFormat('d M Y H:i') }}</div>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-semibold">{{ $rental->total_days }} Hari</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</div>
                                @if($rental->remaining_balance > 0)
                                    <span class="text-[10px] text-rose-600 font-semibold block">Sisa: Rp {{ number_format($rental->remaining_balance, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-[10px] text-emerald-600 font-semibold block"><i class="fa-solid fa-check text-[8px]"></i> Lunas</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($rental->status === 'menunggu_konfirmasi')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-[10px] font-bold">Menunggu Konfirmasi</span>
                                @elseif($rental->status === 'dikonfirmasi')
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg text-[10px] font-bold">Dikonfirmasi (Siap Ambil)</span>
                                @elseif($rental->status === 'sedang_berjalan')
                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-[10px] font-bold">Sedang Berjalan</span>
                                @elseif($rental->status === 'selesai')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-[10px] font-bold">Selesai Dikembalikan</span>
                                @else
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-[10px] font-bold">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('customer.rentals.show', $rental->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-blue-600 hover:text-white rounded-lg text-slate-700 font-bold transition inline-flex items-center gap-1">
                                    <span>Detail & Bayar</span> <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-receipt text-3xl mb-2 text-slate-300"></i>
                                <p>Belum ada riwayat booking rental.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $rentals->links() }}
        </div>
    </div>
</div>
@endsection

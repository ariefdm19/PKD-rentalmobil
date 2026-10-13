@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran Sewa - Admin PKD Rental')
@section('page_title', 'Verifikasi Pembayaran Pelanggan')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.payments.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode bayar / kode sewa..." class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none w-full sm:w-64">
            
            <select name="status" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="menunggu_konfirmasi" {{ request('status') == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima (Valid)</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Kode Pembayaran</th>
                        <th class="py-4 px-6">Penyewa & Kode Rental</th>
                        <th class="py-4 px-6">Nominal & Tipe</th>
                        <th class="py-4 px-6">Metode & Waktu</th>
                        <th class="py-4 px-6">Status Verifikasi</th>
                        <th class="py-4 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $pay)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                {{ $pay->payment_code }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $pay->rental->user->name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $pay->rental->rental_code }} &bull; {{ $pay->rental->car->name }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-black text-slate-900 text-sm">Rp {{ number_format($pay->amount, 0, ',', '.') }}</div>
                                <span class="capitalize text-[10px] text-slate-500">{{ str_replace('_', ' ', $pay->type) }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <div class="font-semibold uppercase text-slate-800">{{ str_replace('_', ' ', $pay->method) }}</div>
                                <div class="text-[10px] text-slate-400">{{ $pay->created_at->translatedFormat('d M Y, H:i') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($pay->status === 'menunggu_konfirmasi')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-bold text-[10px]">Menunggu Verifikasi</span>
                                @elseif($pay->status === 'diterima')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-bold text-[10px]"><i class="fa-solid fa-check text-[8px] mr-1"></i>Diterima</span>
                                @else
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg font-bold text-[10px]">Ditolak</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.payments.show', $pay->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg font-bold transition inline-flex items-center gap-1">
                                    Periksa Bukti <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">Belum ada transaksi pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection

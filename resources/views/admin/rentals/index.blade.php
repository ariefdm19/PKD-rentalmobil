@extends('layouts.admin')

@section('title', 'Manajemen Transaksi Sewa - Admin PKD Rental')
@section('page_title', 'Daftar Transaksi Sewa Mobil')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.rentals.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode rental / nama pelanggan..." class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none w-full sm:w-64">
            
            <select name="status" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <option value="">Semua Status Transaksi</option>
                <option value="menunggu_konfirmasi" {{ request('status') == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="sedang_berjalan" {{ request('status') == 'sedang_berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>

        <a href="{{ route('admin.rentals.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-plus"></i> Buat Sewa Baru (Kasir)
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Kode Rental</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Armada Mobil</th>
                        <th class="py-4 px-6">Jadwal Sewa</th>
                        <th class="py-4 px-6">Total & Pelunasan</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rentals as $rental)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                <a href="{{ route('admin.rentals.show', $rental->id) }}" class="hover:underline">
                                    {{ $rental->rental_code }}
                                </a>
                                <span class="block text-[10px] text-slate-400 font-sans font-normal">{{ $rental->created_at->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $rental->user->name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $rental->user->phone }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800">{{ $rental->car->name }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $rental->car->plate_number }} &bull; {{ $rental->driver ? 'Driver: ' . $rental->driver->name : 'Lepas Kunci' }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <div>{{ $rental->start_date->translatedFormat('d/m/Y') }} - {{ $rental->end_date->translatedFormat('d/m/Y') }}</div>
                                <span class="text-[10px] text-slate-400">Durasi: {{ $rental->total_days }} Hari</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-extrabold text-slate-900">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</div>
                                @if($rental->remaining_balance > 0)
                                    <span class="text-[10px] text-rose-600 font-semibold block">Kurang: Rp {{ number_format($rental->remaining_balance, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-[10px] text-emerald-600 font-semibold block"><i class="fa-solid fa-check text-[8px]"></i> Lunas</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold capitalize
                                    @if($rental->status === 'selesai') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($rental->status === 'sedang_berjalan') bg-indigo-50 text-indigo-700 border border-indigo-200
                                    @elseif($rental->status === 'dikonfirmasi') bg-blue-50 text-blue-700 border border-blue-200
                                    @elseif($rental->status === 'menunggu_konfirmasi') bg-amber-50 text-amber-700 border border-amber-200
                                    @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                                    {{ str_replace('_', ' ', $rental->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.rentals.show', $rental->id) }}" class="px-2.5 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg font-bold transition inline-flex items-center gap-1" title="Detail Transaksi">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.rentals.print', $rental->id) }}" target="_blank" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold transition inline-flex items-center gap-1" title="Cetak Surat Perjanjian">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                                @if(in_array($rental->status, ['sedang_berjalan', 'dikonfirmasi']))
                                    <a href="{{ route('admin.returns.create', ['rental_id' => $rental->id]) }}" class="px-2.5 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-lg font-bold transition inline-flex items-center gap-1" title="Proses Pengembalian">
                                        <i class="fa-solid fa-car-tunnel"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Belum ada transaksi sewa mobil.</td>
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

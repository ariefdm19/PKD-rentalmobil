@extends('layouts.admin')

@section('title', 'Daftar Pengembalian & Denda - Admin PKD Rental')
@section('page_title', 'Inspeksi Pengembalian & Denda')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-extrabold text-base text-slate-900">Histori Pengembalian Unit</h3>
            <p class="text-xs text-slate-400">Pengecekan fisik mobil, keterlambatan jam, dan kalkulasi denda penalti</p>
        </div>
        <a href="{{ route('admin.returns.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Input Pengembalian Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Kode Rental</th>
                        <th class="py-4 px-6">Mobil & Pelanggan</th>
                        <th class="py-4 px-6">Waktu Kembali</th>
                        <th class="py-4 px-6">Keterlambatan (Jam)</th>
                        <th class="py-4 px-6">Kondisi & Bensin</th>
                        <th class="py-4 px-6">Total Denda</th>
                        <th class="py-4 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($returns as $ret)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                {{ $ret->rental->rental_code }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $ret->rental->car->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $ret->rental->user->name }} &bull; Plat: {{ $ret->rental->car->plate_number }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-700">
                                {{ $ret->actual_return_date->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($ret->delay_hours > 0)
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-700 font-bold rounded text-[10px]">Telat {{ $ret->delay_hours }} Jam</span>
                                @else
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded text-[10px]">Tepat Waktu</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <span class="capitalize font-semibold">{{ str_replace('_', ' ', $ret->condition_status) }}</span>
                                <div class="text-[10px] text-slate-400">BBM: {{ $ret->fuel_level_return }}</div>
                            </td>
                            <td class="py-4 px-6 font-black text-rose-600 text-sm">
                                Rp {{ number_format($ret->total_penalty, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.returns.show', $ret->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg font-bold transition inline-flex items-center gap-1">
                                    Detail <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Belum ada data pengembalian unit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $returns->links() }}
        </div>
    </div>
</div>
@endsection

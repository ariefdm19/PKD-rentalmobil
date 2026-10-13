@extends('layouts.admin')

@section('title', 'Perawatan & Servis Armada - Admin')
@section('page_title', 'Perawatan Kendaraan (Maintenance)')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-extrabold text-base text-slate-900">Histori Servis & Biaya Perawatan</h3>
            <p class="text-xs text-slate-400">Total Pengeluaran Perawatan: <strong class="text-rose-600">Rp {{ number_format($totalCost, 0, ',', '.') }}</strong></p>
        </div>
        <a href="{{ route('admin.maintenances.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Catat Servis Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Armada Mobil</th>
                        <th class="py-4 px-6">Jenis Servis / Pekerjaan</th>
                        <th class="py-4 px-6">Tanggal Servis</th>
                        <th class="py-4 px-6">Bengkel / Lokasi</th>
                        <th class="py-4 px-6">Biaya Servis</th>
                        <th class="py-4 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($maintenances as $m)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $m->car->name }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $m->car->plate_number }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $m->service_type }}</div>
                                <div class="text-[11px] text-slate-500 line-clamp-1">{{ $m->description ?: '-' }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $m->maintenance_date->translatedFormat('d F Y') }}
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-medium">
                                {{ $m->workshop_name ?: 'Bengkel Rekanan' }}
                            </td>
                            <td class="py-4 px-6 font-black text-rose-600 text-sm">
                                Rp {{ number_format($m->cost, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <form action="{{ route('admin.maintenances.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan perawatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">Belum ada catatan servis perawatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $maintenances->links() }}
        </div>
    </div>
</div>
@endsection

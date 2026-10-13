@extends('layouts.admin')

@section('title', 'Manajemen Sopir - Admin PKD Rental')
@section('page_title', 'Daftar Sopir & Pengemudi')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.drivers.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sopir / no SIM..." class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none w-full sm:w-64">
            
            <select name="status" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="bertugas" {{ request('status') == 'bertugas' ? 'selected' : '' }}>Bertugas</option>
                <option value="libur" {{ request('status') == 'libur' ? 'selected' : '' }}>Libur</option>
            </select>

            <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>

        <a href="{{ route('admin.drivers.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Sopir Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Nama Driver</th>
                        <th class="py-4 px-6">Kontak & No SIM</th>
                        <th class="py-4 px-6">Tarif Harian</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Catatan Pengalaman</th>
                        <th class="py-4 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($drivers as $driver)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $driver->photo ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80' }}" alt="{{ $driver->name }}" class="w-11 h-11 object-cover rounded-xl shadow-sm">
                                    <div class="font-bold text-slate-900 text-sm">{{ $driver->name }}</div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800">{{ $driver->phone }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $driver->sim_number }}</div>
                            </td>
                            <td class="py-4 px-6 font-bold text-blue-600 text-sm">
                                Rp {{ number_format($driver->daily_rate, 0, ',', '.') }} <span class="text-[10px] text-slate-400 font-normal">/hari</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($driver->status === 'tersedia')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-bold text-[10px]">Tersedia</span>
                                @elseif($driver->status === 'bertugas')
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg font-bold text-[10px]">Bertugas</span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg font-bold text-[10px]">Libur</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-600 text-[11px] max-w-xs truncate">
                                {{ $driver->notes ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="p-2 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus driver ini?')">
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
                            <td colspan="6" class="py-12 text-center text-slate-400">Belum ada data driver sopir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $drivers->links() }}
        </div>
    </div>
</div>
@endsection

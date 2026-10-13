@extends('layouts.admin')

@section('title', 'Manajemen Armada Mobil - PKD Rental')
@section('page_title', 'Daftar Armada Kendaraan')

@section('content')
<div class="space-y-6">
    <!-- Header Controls -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.cars.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / plat nomor..." class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none w-full sm:w-56">
            
            <select name="status" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                <option value="perawatan" {{ request('status') == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <select name="category_id" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>

        <a href="{{ route('admin.cars.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-plus"></i> Tambah Mobil Baru
        </a>
    </div>

    <!-- Table Mobil -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Mobil & Foto</th>
                        <th class="py-4 px-6">Plat Polisi</th>
                        <th class="py-4 px-6">Kategori & Spesifikasi</th>
                        <th class="py-4 px-6">Tarif Sewa / Hari</th>
                        <th class="py-4 px-6">Status Mobil</th>
                        <th class="py-4 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cars as $car)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $car->image ? (str_starts_with($car->image, 'http') ? $car->image : asset('storage/' . $car->image)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $car->name }}" class="w-14 h-11 object-cover rounded-xl shadow-sm">
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $car->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $car->brand }} &bull; {{ $car->year }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono font-bold text-slate-800 text-sm">
                                <span class="px-2 py-1 bg-slate-100 rounded-lg border border-slate-200">{{ $car->plate_number }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <div class="font-semibold text-slate-800">{{ $car->category->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $car->transmission }} &bull; {{ $car->seating_capacity }} Kursi &bull; {{ $car->fuel_type }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-extrabold text-blue-600 text-sm">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-slate-400">Denda: Rp {{ number_format($car->penalty_per_hour, 0, ',', '.') }}/jam</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($car->status === 'tersedia')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-bold text-[10px]"><i class="fa-solid fa-circle text-[7px] mr-1"></i>Tersedia</span>
                                @elseif($car->status === 'disewa')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-bold text-[10px]"><i class="fa-solid fa-circle text-[7px] mr-1"></i>Sedang Disewa</span>
                                @elseif($car->status === 'perawatan')
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg font-bold text-[10px]"><i class="fa-solid fa-wrench mr-1"></i>Perawatan</span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg font-bold text-[10px]">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.cars.edit', $car->id) }}" class="p-2 text-slate-600 hover:text-blue-600 transition" title="Edit Mobil">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus mobil ini?')">
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
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-car-side text-3xl mb-2 text-slate-300"></i>
                                <p>Belum ada data armada mobil yang cocok.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $cars->links() }}
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Manajemen Kategori Mobil')
@section('page_title', 'Kategori Armada Mobil')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Form Tambah Kategori -->
    <div class="lg:col-span-4">
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm sticky top-28 space-y-4">
            <h3 class="font-extrabold text-base text-slate-900">Tambah Kategori Baru</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori</label>
                    <input type="text" name="name" required placeholder="Contoh: MPV Luxury, Sedan VIP" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Kategori</label>
                    <textarea name="description" rows="3" placeholder="Keterangan singkat keunggulan tipe mobil ini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"></textarea>
                </div>
                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-plus"></i> Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <!-- Table Kategori -->
    <div class="lg:col-span-8">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-extrabold text-base text-slate-900">Daftar Kategori Mobil</h3>
                <span class="text-xs text-slate-400 font-semibold">{{ $categories->count() }} Kategori Aktif</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-6">Nama Kategori</th>
                            <th class="py-3.5 px-6">Slug URL</th>
                            <th class="py-3.5 px-6">Jumlah Unit</th>
                            <th class="py-3.5 px-6 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-sm">{{ $cat->name }}</div>
                                    <div class="text-[11px] text-slate-500 line-clamp-1">{{ $cat->description ?: '-' }}</div>
                                </td>
                                <td class="py-4 px-6 font-mono text-slate-600">
                                    {{ $cat->slug }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded-lg text-xs">{{ $cat->cars_count }} Mobil</span>
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-500 hover:text-rose-700 transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">Belum ada kategori mobil.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

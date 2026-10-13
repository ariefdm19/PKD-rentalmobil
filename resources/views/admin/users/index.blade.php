@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Akun - Admin')
@section('page_title', 'Manajemen Pengguna & Hak Akses')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email / no telp..." class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none w-full sm:w-64">
            
            <select name="role" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                <option value="">Semua Peran (Role)</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas Lapangan</option>
                <option value="pelanggan" {{ request('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
            </select>

            <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>

        <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i> Tambah Pengguna Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Nama Pengguna</th>
                        <th class="py-4 px-6">Email & Telepon</th>
                        <th class="py-4 px-6">Peran (Role)</th>
                        <th class="py-4 px-6">Identitas NIK</th>
                        <th class="py-4 px-6">Status Akun</th>
                        <th class="py-4 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900 text-sm">{{ $u->name }}</div>
                                <span class="text-[10px] text-slate-400">Terdaftar: {{ $u->created_at->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-slate-800">{{ $u->email }}</div>
                                <div class="text-[11px] text-slate-400">{{ $u->phone ?: '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($u->role === 'admin')
                                    <span class="px-2.5 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-lg font-bold text-[10px] uppercase">Administrator</span>
                                @elseif($u->role === 'petugas')
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg font-bold text-[10px] uppercase">Petugas Lapangan</span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg font-bold text-[10px] uppercase">Pelanggan</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-mono">
                                {{ $u->nik ?: '-' }}
                            </td>
                            <td class="py-4 px-6">
                                @if($u->is_active)
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-bold text-[10px]">Aktif</span>
                                @else
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-lg font-bold text-[10px]">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="p-2 text-slate-600 hover:text-blue-600 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if($u->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

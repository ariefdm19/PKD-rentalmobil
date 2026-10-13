@extends('layouts.admin')

@section('title', 'Tambah Sopir Baru - Admin')
@section('page_title', 'Tambah Data Sopir')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Sopir</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp / HP</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="081234567890" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor SIM A / B1</label>
                    <input type="text" name="sim_number" required value="{{ old('sim_number') }}" placeholder="SIM-A-987654" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tarif Harian (Rp / Hari)</label>
                    <input type="number" name="daily_rate" required value="{{ old('daily_rate', 150000) }}" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-blue-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Status Driver</label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="tersedia">Tersedia (Siap Bertugas)</option>
                        <option value="bertugas">Sedang Bertugas</option>
                        <option value="libur">Libur / Cuti</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Foto Profil Driver</label>
                <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Pengalaman / Lisensi</label>
                <textarea name="notes" rows="3" placeholder="Paham rute luar kota, pengalaman mengemudi 5 tahun..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.drivers.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition">
                    Simpan Data Sopir
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

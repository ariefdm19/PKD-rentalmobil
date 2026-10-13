@extends('layouts.admin')

@section('title', 'Edit Data Sopir - Admin')
@section('page_title', 'Edit Driver ' . $driver->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Sopir</label>
                <input type="text" name="name" required value="{{ old('name', $driver->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp / HP</label>
                    <input type="text" name="phone" required value="{{ old('phone', $driver->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor SIM</label>
                    <input type="text" name="sim_number" required value="{{ old('sim_number', $driver->sim_number) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tarif Harian (Rp / Hari)</label>
                    <input type="number" name="daily_rate" required value="{{ old('daily_rate', $driver->daily_rate) }}" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-blue-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Status Driver</label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="tersedia" {{ $driver->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="bertugas" {{ $driver->status == 'bertugas' ? 'selected' : '' }}>Bertugas</option>
                        <option value="libur" {{ $driver->status == 'libur' ? 'selected' : '' }}>Libur</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Ganti Foto Profil</label>
                <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Pengalaman</label>
                <textarea name="notes" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">{{ old('notes', $driver->notes) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.drivers.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

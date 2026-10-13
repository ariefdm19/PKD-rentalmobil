@extends('layouts.admin')

@section('title', 'Catat Servis Mobil Baru - Admin')
@section('page_title', 'Input Perawatan & Servis Armada')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.maintenances.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Armada Mobil</label>
                <select name="car_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">-- Pilih Mobil --</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->name }} ({{ $car->plate_number }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Servis</label>
                    <input type="text" name="service_type" required placeholder="Ganti Oli Mesin, Kampas Rem, Tune Up..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Perawatan</label>
                    <input type="date" name="maintenance_date" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Total Biaya Servis (Rp)</label>
                    <input type="number" name="cost" required placeholder="500000" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-rose-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Bengkel / Toko</label>
                    <input type="text" name="workshop_name" placeholder="Bengkel Resmi Auto2000, Shop & Drive" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Ubah Status Mobil Saat Ini (Opsional)</label>
                <select name="set_car_status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs">
                    <option value="">Jangan ubah status mobil</option>
                    <option value="perawatan">Set ke 'Perawatan' (Mobil Masuk Bengkel)</option>
                    <option value="tersedia">Set ke 'Tersedia' (Servis Selesai & Siap Sewa)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Keterangan Tambahan / Sparepart</label>
                <textarea name="description" rows="3" placeholder="Ganti oli Shell Helix 4L, filter oli asli, cek minyak rem..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.maintenances.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition">
                    Simpan Catatan Servis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

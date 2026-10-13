@extends('layouts.admin')

@section('title', 'Tambah Armada Mobil - Admin PKD Rental')
@section('page_title', 'Tambah Unit Mobil Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Model Mobil</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: All New Avanza 1.5 G CVT" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Merk / Pabrikan</label>
                    <input type="text" name="brand" required value="{{ old('brand') }}" placeholder="Toyota / Honda / Mitsubishi / Suzuki" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Plat Nomor Polisi</label>
                    <input type="text" name="plate_number" required value="{{ old('plate_number') }}" placeholder="D 1234 PKD" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono uppercase focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="car_category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun Pembuatan</label>
                    <input type="number" name="year" required value="{{ old('year', date('Y')) }}" min="2000" max="{{ date('Y')+1 }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Transmisi</label>
                    <select name="transmission" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="Automatic">Automatic (Matic)</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Bahan Bakar</label>
                    <select name="fuel_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="Bensin">Bensin</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Listrik">Listrik (EV)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Kapasitas Kursi</label>
                    <input type="number" name="seating_capacity" required value="{{ old('seating_capacity', 7) }}" min="2" max="50" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tarif Sewa (Rp / Hari)</label>
                    <input type="number" name="price_per_day" required value="{{ old('price_per_day', 400000) }}" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-blue-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Denda Telat (Rp / Jam)</label>
                    <input type="number" name="penalty_per_hour" required value="{{ old('penalty_per_hour', 40000) }}" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-rose-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Status Mobil</label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="tersedia">Tersedia (Siap Jalan)</option>
                        <option value="disewa">Sedang Disewa</option>
                        <option value="perawatan">Dalam Perawatan (Bengkel)</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Foto Mobil</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Atau URL Gambar Online (Opsional)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Fitur Unggulan (Pisahkan Koma)</label>
                <input type="text" name="features" value="{{ old('features', 'AC Double Blower, Bluetooth Audio, Kamera Parkir, USB Charger') }}" placeholder="AC Double Blower, Kamera Parkir..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Detail</label>
                <textarea name="description" rows="3" placeholder="Informasi kenyamanan mobil..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.cars.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition">
                    Simpan Unit Mobil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Edit Mobil ' . $car->name . ' - Admin')
@section('page_title', 'Edit Data Mobil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Model Mobil</label>
                    <input type="text" name="name" required value="{{ old('name', $car->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Merk / Pabrikan</label>
                    <input type="text" name="brand" required value="{{ old('brand', $car->brand) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Plat Nomor Polisi</label>
                    <input type="text" name="plate_number" required value="{{ old('plate_number', $car->plate_number) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono uppercase focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="car_category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $car->car_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun</label>
                    <input type="number" name="year" required value="{{ old('year', $car->year) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Transmisi</label>
                    <select name="transmission" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="Automatic" {{ $car->transmission == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option value="Manual" {{ $car->transmission == 'Manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Bahan Bakar</label>
                    <select name="fuel_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="Bensin" {{ $car->fuel_type == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                        <option value="Diesel" {{ $car->fuel_type == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Hybrid" {{ $car->fuel_type == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="Listrik" {{ $car->fuel_type == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Kapasitas Kursi</label>
                    <input type="number" name="seating_capacity" required value="{{ old('seating_capacity', $car->seating_capacity) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Tarif Sewa (Rp / Hari)</label>
                    <input type="number" name="price_per_day" required value="{{ old('price_per_day', $car->price_per_day) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-blue-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Denda Telat (Rp / Jam)</label>
                    <input type="number" name="penalty_per_hour" required value="{{ old('penalty_per_hour', $car->penalty_per_hour) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-rose-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Status Mobil</label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs">
                        <option value="tersedia" {{ $car->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disewa" {{ $car->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                        <option value="perawatan" {{ $car->status == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                        <option value="nonaktif" {{ $car->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Ganti Foto Mobil</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Ganti URL Gambar</label>
                    <input type="url" name="image_url" value="{{ old('image_url', str_starts_with($car->image ?? '', 'http') ? $car->image : '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Fitur</label>
                <input type="text" name="features" value="{{ old('features', $car->features) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">{{ old('description', $car->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.cars.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

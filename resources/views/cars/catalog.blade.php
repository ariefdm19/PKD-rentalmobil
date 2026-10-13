@extends('layouts.app')

@section('title', 'Katalog Semua Mobil - PKD Rental Mobil')

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Katalog Armada PKD Rental</h1>
        <p class="text-slate-400 text-sm mt-2">Pilih mobil terbaik yang sesuai dengan kebutuhan perjalanan dan budget Anda.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Filter -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-28">
                <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center justify-between">
                    <span>Filter Armada</span>
                    <a href="{{ route('cars.catalog') }}" class="text-xs text-blue-600 font-semibold hover:underline">Reset</a>
                </h3>

                <form action="{{ route('cars.catalog') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori</label>
                        <select name="category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Transmisi</label>
                        <select name="transmission" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            <option value="">Semua Transmisi</option>
                            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Matic</option>
                            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bahan Bakar</label>
                        <select name="fuel" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            <option value="">Semua Bahan Bakar</option>
                            <option value="Bensin" {{ request('fuel') == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                            <option value="Diesel" {{ request('fuel') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="Hybrid" {{ request('fuel') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="Listrik" {{ request('fuel') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Harga</label>
                        <select name="sort" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            <option value="">Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition">
                        Terapkan Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Car Cards -->
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($cars as $car)
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-lg transition group flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 bg-slate-100 overflow-hidden">
                                <img src="{{ $car->image ? (str_starts_with($car->image, 'http') ? $car->image : asset('storage/' . $car->image)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80' }}" 
                                     alt="{{ $car->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute top-2.5 left-2.5">
                                    <span class="px-2.5 py-1 bg-slate-900/80 backdrop-blur text-white text-[10px] font-bold rounded-lg uppercase">
                                        {{ $car->category->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="text-[11px] text-slate-400 mb-1">{{ $car->brand }} &bull; {{ $car->year }}</div>
                                <h3 class="text-base font-bold text-slate-900 mb-2 truncate">{{ $car->name }}</h3>
                                <div class="flex items-center gap-3 text-xs text-slate-500 py-2 border-y border-slate-100 mb-3">
                                    <span><i class="fa-solid fa-users mr-1"></i>{{ $car->seating_capacity }}</span>
                                    <span><i class="fa-solid fa-gears mr-1"></i>{{ $car->transmission }}</span>
                                    <span><i class="fa-solid fa-gas-pump mr-1"></i>{{ $car->fuel_type }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-1 flex items-center justify-between border-t border-slate-50">
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase font-medium">Tarif / Hari</span>
                                <span class="text-sm font-extrabold text-blue-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('cars.detail', $car->id) }}" class="px-3.5 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg text-xs font-bold transition">
                                Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300">
                        <i class="fa-solid fa-car-side text-4xl text-slate-300 mb-2"></i>
                        <p class="text-sm font-semibold text-slate-600">Tidak ada mobil yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

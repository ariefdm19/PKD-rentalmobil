@extends('layouts.app')

@section('title', 'PKD Rental Mobil - Solusi Sewa Mobil Terpercaya & Lengkap')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white pt-16 pb-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-400/20 text-blue-300 text-xs font-semibold backdrop-blur">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                    Armada Bersih, Nyaman & Siap Pakai 24/7
                </div>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Sewa Mobil Nyaman, <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-sky-400">Harga Terjangkau</span> Tanpa Ribet
                </h1>
                <p class="text-base sm:text-lg text-slate-300 max-w-2xl font-normal leading-relaxed">
                    Tersedia mobil keluarga (MPV), SUV gagah, City Car lincah, hingga HiAce minibus rombongan. Lepas kunci atau plus driver berpengalaman siap mengantar perjalanan Anda.
                </p>
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start pt-2">
                    <a href="#booking-fast" class="px-7 py-3.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-sm font-bold shadow-xl shadow-blue-600/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari Mobil Sekarang
                    </a>
                    <a href="{{ route('cars.catalog') }}" class="px-7 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                        <i class="fa-solid fa-car-side"></i> Semua Armada
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-3xl blur opacity-30"></div>
                    <div class="relative bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 shadow-2xl backdrop-blur">
                        <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80" alt="Rental Mobil PKD" class="w-full h-56 object-cover rounded-xl mb-4 shadow-md">
                        <div class="flex items-center justify-between text-xs text-slate-300">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-gas-pump text-amber-400"></i> BBM Terisi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-spray-can-sparkles text-emerald-400"></i> Higienis & Wangi</span>
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-blue-400"></i> Asuransi Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Search Widget -->
<section id="booking-fast" class="relative -mt-10 z-20 max-w-6xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-6">
        <form action="{{ route('home') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Unit</label>
                <select name="category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Transmisi</label>
                <select name="transmission" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">Semua Transmisi</option>
                    <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic (Matic)</option>
                    <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kapasitas</label>
                <select name="capacity" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">Semua Kapasitas</option>
                    <option value="5" {{ request('capacity') == '5' ? 'selected' : '' }}>Min. 5 Kursi</option>
                    <option value="7" {{ request('capacity') == '7' ? 'selected' : '' }}>Min. 7 Kursi</option>
                    <option value="12" {{ request('capacity') == '12' ? 'selected' : '' }}>Rombongan 12+ Kursi</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Cari Nama Mobil</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: Avanza, Fortuner" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-600/30 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Fleet Catalog Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-4">
        <div>
            <div class="text-xs font-extrabold uppercase tracking-wider text-blue-600 mb-1">Armada Pilihan</div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Daftar Mobil Siap Jalan</h2>
        </div>
        <a href="{{ route('cars.catalog') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5 group">
            Lihat Semua Unit <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($cars as $car)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col justify-between">
                <div>
                    <!-- Image Card -->
                    <div class="relative h-52 bg-slate-100 overflow-hidden">
                        <img src="{{ $car->image ? (str_starts_with($car->image, 'http') ? $car->image : asset('storage/' . $car->image)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $car->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-slate-900/80 backdrop-blur text-white text-[11px] font-bold rounded-lg uppercase tracking-wider">
                                {{ $car->category->name }}
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            @if($car->status === 'tersedia')
                                <span class="px-3 py-1 bg-emerald-500/90 backdrop-blur text-white text-[11px] font-bold rounded-lg flex items-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-check text-[9px]"></i> Tersedia
                                </span>
                            @elseif($car->status === 'disewa')
                                <span class="px-3 py-1 bg-amber-500/90 backdrop-blur text-white text-[11px] font-bold rounded-lg flex items-center gap-1">
                                    <i class="fa-solid fa-clock text-[9px]"></i> Sedang Disewa
                                </span>
                            @else
                                <span class="px-3 py-1 bg-slate-500/90 backdrop-blur text-white text-[11px] font-bold rounded-lg capitalize">
                                    {{ $car->status }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs text-slate-400 mb-1">
                            <span>{{ $car->brand }} &bull; {{ $car->year }}</span>
                            <div class="flex items-center text-amber-500 font-bold gap-1">
                                <i class="fa-solid fa-star text-xs"></i>
                                <span>{{ number_format($car->averageRating(), 1) }}</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition truncate">{{ $car->name }}</h3>
                        
                        <!-- Specs -->
                        <div class="grid grid-cols-3 gap-2 py-3 border-y border-slate-100 text-xs text-slate-600 mb-4">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-users text-slate-400"></i>
                                <span>{{ $car->seating_capacity }} Kursi</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-gears text-slate-400"></i>
                                <span>{{ $car->transmission }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-gas-pump text-slate-400"></i>
                                <span>{{ $car->fuel_type }}</span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $car->description ?: 'Mobil sangat nyaman dan siap pakai untuk perjalanan Anda.' }}
                        </p>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="px-6 pb-6 pt-2 flex items-center justify-between bg-slate-50/50 border-t border-slate-100">
                    <div>
                        <div class="text-[10px] text-slate-500 font-medium uppercase">Tarif Sewa</div>
                        <div class="text-base font-extrabold text-blue-600">
                            Rp {{ number_format($car->price_per_day, 0, ',', '.') }}<span class="text-xs text-slate-500 font-normal"> /hari</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('cars.detail', $car->id) }}" class="px-3.5 py-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition" title="Lihat Detail">
                            Detail
                        </a>
                        @if($car->status === 'tersedia')
                            <a href="{{ route('rentals.booking', $car->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition flex items-center gap-1">
                                Sewa <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        @else
                            <button disabled class="px-3 py-2 bg-slate-200 text-slate-400 rounded-xl text-xs font-semibold cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300">
                <i class="fa-solid fa-car-tunnel text-4xl text-slate-300 mb-3"></i>
                <h3 class="text-base font-bold text-slate-700">Tidak ada armada yang sesuai filter</h3>
                <p class="text-xs text-slate-500 mt-1">Silakan reset filter pencarian Anda untuk melihat unit lain.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold">Reset Pencarian</a>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $cars->links() }}
    </div>
</section>

<!-- Keunggulan Section -->
<section id="keunggulan" class="bg-slate-900 text-white py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="text-xs font-extrabold uppercase tracking-wider text-blue-400 mb-2">Kenapa Memilih Kami?</div>
            <h2 class="text-3xl font-extrabold tracking-tight">Kenyamanan Perjalanan Anda Adalah Prioritas Utama</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="bg-slate-800/80 border border-slate-700/80 p-6 rounded-2xl space-y-3">
                <div class="w-12 h-12 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-car-on"></i>
                </div>
                <h3 class="font-bold text-lg text-white">Armada Selalu Prima</h3>
                <p class="text-xs text-slate-400 leading-relaxed">Semua mobil menjalani perawatan berkala di bengkel resmi serta dicek teliti sebelum serah terima kunci.</p>
            </div>

            <div class="bg-slate-800/80 border border-slate-700/80 p-6 rounded-2xl space-y-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <h3 class="font-bold text-lg text-white">Tarif Transparan</h3>
                <p class="text-xs text-slate-400 leading-relaxed">Tanpa biaya siluman. Seluruh rincian tarif sewa, overtime per jam, dan sopir tertulis jelas di sistem kontrak.</p>
            </div>

            <div class="bg-slate-800/80 border border-slate-700/80 p-6 rounded-2xl space-y-3">
                <div class="w-12 h-12 rounded-xl bg-amber-600/20 text-amber-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <h3 class="font-bold text-lg text-white">Driver Profesional</h3>
                <p class="text-xs text-slate-400 leading-relaxed">Sopir berlisensi resmi, ramah, berpakaian rapi, dan paham betul rute jalan pintas bebas macet.</p>
            </div>

            <div class="bg-slate-800/80 border border-slate-700/80 p-6 rounded-2xl space-y-3">
                <div class="w-12 h-12 rounded-xl bg-purple-600/20 text-purple-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-handshake-angle"></i>
                </div>
                <h3 class="font-bold text-lg text-white">Proses Booking Cepat</h3>
                <p class="text-xs text-slate-400 leading-relaxed">Pesan langsung dari ponsel, upload identitas dan transfer DP, unit langsung siap diantar ke lokasi Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Sopir Section -->
<section id="sopir" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center max-w-2xl mx-auto mb-14">
        <div class="text-xs font-extrabold uppercase tracking-wider text-blue-600 mb-2">Pilihan Sopir Berpengalaman</div>
        <h2 class="text-3xl font-extrabold text-slate-900">Nikmati Perjalanan Santai Tanpa Lelah Menyetir</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($drivers as $driver)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex items-start gap-4">
                <img src="{{ $driver->photo ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80' }}" alt="{{ $driver->name }}" class="w-20 h-20 rounded-2xl object-cover shadow">
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-slate-900 text-sm">{{ $driver->name }}</h4>
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md">Siap Kerja</span>
                    </div>
                    <div class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-id-card text-blue-500 mr-1"></i>{{ $driver->sim_number }}</div>
                    <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">{{ $driver->notes }}</p>
                    <div class="mt-3 text-xs font-bold text-blue-600">
                        Rp {{ number_format($driver->daily_rate, 0, ',', '.') }} <span class="text-slate-400 font-normal">/hari</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Testimoni Pelanggan -->
<section id="testimoni" class="bg-slate-100/70 py-20 border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="text-xs font-extrabold uppercase tracking-wider text-blue-600 mb-2">Testimoni Nyata</div>
            <h2 class="text-3xl font-extrabold text-slate-900">Kata Mereka yang Telah Menyewa</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($reviews as $rev)
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-sm">
                        @for($i = 1; $i <= $rev->rating; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-600 italic leading-relaxed">"{{ $rev->comment }}"</p>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-900">{{ $rev->user->name }}</span>
                        <span class="text-[11px] text-blue-600 font-medium">{{ $rev->car->name }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-slate-400 text-sm py-8">Belum ada review yang ditampilkan.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection

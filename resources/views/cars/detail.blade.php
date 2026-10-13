@extends('layouts.app')

@section('title', $car->name . ' - Detail PKD Rental Mobil')

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="text-xs text-blue-400 font-bold uppercase tracking-wider mb-1">{{ $car->category->name }} &bull; {{ $car->brand }}</div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $car->name }}</h1>
        </div>
        <div class="text-left sm:text-right">
            <div class="text-xs text-slate-400 uppercase">Tarif Sewa</div>
            <div class="text-2xl font-black text-emerald-400">
                Rp {{ number_format($car->price_per_day, 0, ',', '.') }}<span class="text-xs text-slate-300 font-normal"> /24 jam</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Detail Info & Image -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Main Photo -->
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm">
                <img src="{{ $car->image ? (str_starts_with($car->image, 'http') ? $car->image : asset('storage/' . $car->image)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80' }}" 
                     alt="{{ $car->name }}" 
                     class="w-full h-80 sm:h-96 object-cover">
            </div>

            <!-- Specs Grid -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-600"></i> Spesifikasi & Informasi Unit
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-slate-400 uppercase text-[10px] font-bold">Kapasitas</div>
                        <div class="font-extrabold text-sm text-slate-800 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-users text-blue-500"></i> {{ $car->seating_capacity }} Penumpang
                        </div>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-slate-400 uppercase text-[10px] font-bold">Transmisi</div>
                        <div class="font-extrabold text-sm text-slate-800 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-gears text-indigo-500"></i> {{ $car->transmission }}
                        </div>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-slate-400 uppercase text-[10px] font-bold">Bahan Bakar</div>
                        <div class="font-extrabold text-sm text-slate-800 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-gas-pump text-amber-500"></i> {{ $car->fuel_type }}
                        </div>
                    </div>
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-slate-400 uppercase text-[10px] font-bold">Tahun Armada</div>
                        <div class="font-extrabold text-sm text-slate-800 mt-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar text-emerald-500"></i> {{ $car->year }}
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Deskripsi Kendaraan</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $car->description ?: 'Mobil dalam kondisi prima, full service berkala, interior harum dan bersih siap melayani perjalanan pribadi, keluarga, maupun instansi Anda.' }}
                    </p>
                </div>

                @if(!empty($car->features))
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Fitur & Kelengkapan</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($car->features_array as $ft)
                                <span class="px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-xl border border-blue-100 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-[10px] text-blue-500"></i> {{ $ft }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Reviews -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center justify-between">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-comments text-blue-600"></i> Ulasan Penyewa ({{ $car->reviews->count() }})</span>
                    <span class="text-amber-500 font-bold text-sm flex items-center gap-1"><i class="fa-solid fa-star"></i> {{ number_format($car->averageRating(), 1) }}</span>
                </h3>

                <div class="space-y-4">
                    @forelse($car->reviews as $rev)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-xs text-slate-900">{{ $rev->user->name }}</span>
                                <div class="flex text-amber-400 text-xs">
                                    @for($i = 1; $i <= $rev->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed italic">"{{ $rev->comment }}"</p>
                            <span class="text-[10px] text-slate-400 mt-2 block">{{ $rev->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">Belum ada ulasan untuk armada ini. Jadilah yang pertama menyewa!</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Sticky Booking Action -->
        <div class="lg:col-span-4">
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 sticky top-28 space-y-6">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Ketersediaan</span>
                    <div class="mt-2">
                        @if($car->status === 'tersedia')
                            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-emerald-800 text-xs font-bold">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                                <span>Unit Ready & Siap Dibooking</span>
                            </div>
                        @else
                            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3 text-amber-800 text-xs font-bold">
                                <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg"></i>
                                <span>Unit Sedang {{ ucfirst($car->status) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>Tarif Mobil</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($car->price_per_day, 0, ',', '.') }} /hari</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Denda Overtime</span>
                        <span class="font-bold text-rose-600">Rp {{ number_format($car->penalty_per_hour, 0, ',', '.') }} /jam</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Opsi Sopir</span>
                        <span class="font-bold text-slate-800">Tersedia (+Rp 150rb/hari)</span>
                    </div>
                </div>

                @if($car->status === 'tersedia')
                    <a href="{{ route('rentals.booking', $car->id) }}" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-calendar-check"></i> Booking Mobil Ini Sekarang
                    </a>
                @else
                    <button disabled class="w-full py-3.5 bg-slate-200 text-slate-400 rounded-xl text-sm font-bold cursor-not-allowed">
                        Mobil Sedang Tidak Tersedia
                    </button>
                @endif

                <a href="https://wa.me/{{ \App\Models\Setting::get('company_whatsapp', '6281234567890') }}?text=Halo%20Admin,%20saya%20tertarik%20sewa%20mobil%20{{ urlencode($car->name) }}" target="_blank" class="w-full py-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp text-emerald-600 text-base"></i> Tanya Admin via WhatsApp
                </a>

                @if(!empty($terms))
                    <div class="pt-4 border-t border-slate-100 text-[11px] text-slate-500 space-y-1">
                        <div class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Syarat Sewa Cepat:</div>
                        <p class="whitespace-pre-line leading-relaxed">{{ $terms }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

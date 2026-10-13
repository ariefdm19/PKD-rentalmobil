@extends('layouts.app')

@section('title', 'Detail Sewa - ' . $rental->rental_code)

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="text-xs text-blue-400 font-bold uppercase tracking-wider mb-1">Kode Transaksi</div>
            <h1 class="text-2xl font-black font-mono tracking-tight">{{ $rental->rental_code }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                @if($rental->status === 'selesai') bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                @elseif($rental->status === 'sedang_berjalan') bg-indigo-500/20 text-indigo-300 border border-indigo-500/30
                @elseif($rental->status === 'dikonfirmasi') bg-blue-500/20 text-blue-300 border border-blue-500/30
                @elseif($rental->status === 'menunggu_konfirmasi') bg-amber-500/20 text-amber-300 border border-amber-500/30
                @else bg-rose-500/20 text-rose-300 border border-rose-500/30 @endif">
                {{ str_replace('_', ' ', $rental->status) }}
            </span>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Detail Sewa & Mobil -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Informasi Kendaraan -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-car-side text-blue-600"></i> Unit Armada
                </h3>
                <div class="flex items-start gap-4">
                    <img src="{{ $rental->car->image ? (str_starts_with($rental->car->image, 'http') ? $rental->car->image : asset('storage/' . $rental->car->image)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $rental->car->name }}" class="w-28 h-20 object-cover rounded-2xl shadow-sm">
                    <div class="space-y-1 text-xs">
                        <div class="text-base font-extrabold text-slate-900">{{ $rental->car->name }}</div>
                        <div class="text-slate-500 font-mono font-bold">{{ $rental->car->plate_number }} &bull; {{ $rental->car->transmission }} &bull; {{ $rental->car->fuel_type }}</div>
                        <div class="text-slate-600">Tarif: Rp {{ number_format($rental->car->price_per_day, 0, ',', '.') }} /hari</div>
                    </div>
                </div>

                @if($rental->driver)
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-3">
                        <img src="{{ $rental->driver->photo ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80' }}" class="w-10 h-10 rounded-xl object-cover">
                        <div class="text-xs">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Driver Bertugas</span>
                            <span class="font-bold text-slate-800">{{ $rental->driver->name }} ({{ $rental->driver->phone }})</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Jadwal & Lokasi -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm text-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-indigo-600"></i> Waktu & Lokasi
                </h3>
                <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div>
                        <span class="text-slate-400 uppercase text-[10px] font-bold block">Mulai Sewa</span>
                        <span class="font-extrabold text-slate-800 text-sm">{{ $rental->start_date->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 uppercase text-[10px] font-bold block">Selesai Sewa</span>
                        <span class="font-extrabold text-slate-800 text-sm">{{ $rental->end_date->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-start gap-2 text-slate-600">
                        <i class="fa-solid fa-location-dot text-emerald-500 mt-1"></i>
                        <span><strong>Ambil:</strong> {{ $rental->pickup_location }}</span>
                    </div>
                    <div class="flex items-start gap-2 text-slate-600">
                        <i class="fa-solid fa-flag-checkered text-rose-500 mt-1"></i>
                        <span><strong>Kembali:</strong> {{ $rental->dropoff_location }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600">
                        <i class="fa-solid fa-id-card text-blue-500"></i>
                        <span><strong>Jaminan:</strong> {{ $rental->guarantee_type }}</span>
                    </div>
                </div>
            </div>

            <!-- Rincian Biaya -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm text-xs space-y-3">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-emerald-600"></i> Rincian Tagihan
                </h3>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Sewa Kendaraan ({{ $rental->total_days }} Hari)</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($rental->car_cost, 0, ',', '.') }}</span>
                </div>
                @if($rental->driver_cost > 0)
                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Jasa Driver ({{ $rental->total_days }} Hari)</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($rental->driver_cost, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between py-2 text-sm font-extrabold text-slate-900 border-b border-slate-200">
                    <span>Total Biaya Sewa</span>
                    <span class="text-blue-600">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Total Pembayaran Masuk (Diterima)</span>
                    <span class="font-bold text-emerald-600">Rp {{ number_format($rental->totalPaid(), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1 text-slate-600">
                    <span>Sisa Pelunasan</span>
                    <span class="font-bold text-rose-600">Rp {{ number_format($rental->remaining_balance, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Review Section Jika Selesai -->
            @if($rental->status === 'selesai')
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-star text-amber-500"></i> Berikan Ulasan Anda
                    </h3>
                    @if($rental->review)
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-xs">
                            <div class="flex text-amber-400 mb-1">
                                @for($i = 1; $i <= $rental->review->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <p class="text-slate-700 italic">"{{ $rental->review->comment }}"</p>
                            <span class="text-[10px] text-emerald-600 font-semibold block mt-1">Ulasan Anda telah dipublikasikan.</span>
                        </div>
                    @else
                        <form action="{{ route('customer.rentals.review', $rental->id) }}" method="POST" class="space-y-3 text-xs">
                            @csrf
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Rating Bintang</label>
                                <select name="rating" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                                    <option value="5">⭐⭐⭐⭐⭐ 5 - Sangat Puas</option>
                                    <option value="4">⭐⭐⭐⭐ 4 - Puas & Bersih</option>
                                    <option value="3">⭐⭐⭐ 3 - Cukup Baik</option>
                                    <option value="2">⭐⭐ 2 - Kurang Puas</option>
                                    <option value="1">⭐ 1 - Buruk</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Komentar / Pengalaman</label>
                                <textarea name="comment" rows="2" required placeholder="Tuliskan kepuasan Anda menyewa di PKD Rental Mobil..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs"></textarea>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-xs transition">
                                Kirim Ulasan
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        <!-- Right: Pembayaran & Upload Bukti Transfer -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Box Rekening Pembayaran -->
            <div class="bg-gradient-to-br from-blue-900 to-indigo-900 text-white p-6 rounded-3xl shadow-xl shadow-blue-900/30 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-blue-300">Rekening Transfer Resmi</span>
                    <i class="fa-solid fa-building-columns text-xl text-blue-300"></i>
                </div>
                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl border border-white/10 space-y-1">
                    <div class="text-xs text-blue-200">{{ $bankInfo['name'] }}</div>
                    <div class="text-2xl font-black font-mono tracking-wider">{{ $bankInfo['account'] }}</div>
                    <div class="text-xs text-blue-100">a/n {{ $bankInfo['holder'] }}</div>
                </div>
                <p class="text-[11px] text-blue-200 leading-relaxed">
                    Silakan transfer nominal DP (minimal 30%) atau pelunasan penuh. Setelah transfer, upload struk foto di bawah ini untuk konfirmasi otomatis.
                </p>
            </div>

            <!-- Form Upload Pembayaran -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-blue-600"></i> Upload Bukti Pembayaran
                </h3>

                <form action="{{ route('customer.rentals.payment', $rental->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Tipe Pembayaran</label>
                        <select name="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                            <option value="dp">Uang Muka (DP 30%)</option>
                            <option value="pelunasan">Pelunasan Sisa</option>
                            <option value="pembayaran_penuh">Pembayaran Penuh (100%)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nominal yang Ditransfer (Rp)</label>
                        <input type="number" name="amount" required value="{{ $rental->remaining_balance > 0 ? $rental->remaining_balance : $rental->down_payment }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Metode Transfer</label>
                        <select name="method" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                            <option value="transfer_bank">Transfer Bank (BCA / Mandiri / BRI / BNI)</option>
                            <option value="qris">QRIS / E-Wallet</option>
                            <option value="tunai">Tunai di Kantor</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Foto Struk / Tangkapan Layar</label>
                        <input type="file" name="proof_file" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Bukti Transfer
                    </button>
                </form>
            </div>

            <!-- Riwayat Pembayaran Transaksi Ini -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Histori Pembayaran</h4>
                <div class="space-y-2 text-xs">
                    @forelse($rental->payments as $pay)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-slate-800 uppercase text-[10px] block">{{ $pay->type }} &bull; {{ $pay->method }}</span>
                                <span class="text-slate-900 font-extrabold">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $pay->created_at->translatedFormat('d M, H:i') }}</span>
                            </div>
                            <div>
                                @if($pay->status === 'diterima')
                                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">Diterima</span>
                                @elseif($pay->status === 'menunggu_konfirmasi')
                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded font-bold text-[10px]">Dicek</span>
                                @else
                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded font-bold text-[10px]">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-slate-400 text-xs">Belum ada pembayaran yang diupload.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

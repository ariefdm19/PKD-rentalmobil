@extends('layouts.admin')

@section('title', 'Detail Transaksi ' . $rental->rental_code)
@section('page_title', 'Detail Transaksi Sewa')

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">No. Kontrak:</span>
                <span class="font-mono text-lg font-black text-blue-600">{{ $rental->rental_code }}</span>
            </div>
            <div class="text-xs text-slate-400 mt-1">Dibuat pada: {{ $rental->created_at->translatedFormat('d F Y, H:i') }}</div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.rentals.print', $rental->id) }}" target="_blank" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print"></i> Cetak Surat Kontrak Sewa
            </a>

            @if(in_array($rental->status, ['dikonfirmasi', 'sedang_berjalan']))
                <a href="{{ route('admin.returns.create', ['rental_id' => $rental->id]) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md shadow-emerald-600/20">
                    <i class="fa-solid fa-car-tunnel"></i> Proses Pengembalian Unit
                </a>
            @endif
        </div>
    </div>

    <!-- Main Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Kolom Kiri: Rincian Sewa, Mobil & Pelanggan -->
        <div class="lg:col-span-8 space-y-6">
            <!-- Data Pelanggan & Mobil -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Box Pelanggan -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3 text-xs">
                    <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user text-blue-600"></i> Identitas Pelanggan
                    </h3>
                    <div class="space-y-1.5 text-slate-600">
                        <div class="font-bold text-slate-900 text-sm">{{ $rental->user->name }}</div>
                        <div><i class="fa-solid fa-phone text-emerald-500 mr-1.5"></i>{{ $rental->user->phone }}</div>
                        <div><i class="fa-solid fa-envelope text-blue-500 mr-1.5"></i>{{ $rental->user->email }}</div>
                        <div><i class="fa-solid fa-id-card text-slate-400 mr-1.5"></i>NIK: {{ $rental->user->nik ?: '-' }}</div>
                        <div><i class="fa-solid fa-location-dot text-rose-500 mr-1.5"></i>{{ $rental->user->address ?: '-' }}</div>
                    </div>
                </div>

                <!-- Box Armada -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3 text-xs">
                    <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-car text-indigo-600"></i> Informasi Armada
                    </h3>
                    <div class="space-y-1.5 text-slate-600">
                        <div class="font-bold text-slate-900 text-sm">{{ $rental->car->name }}</div>
                        <div class="font-mono font-bold text-blue-600"><span class="px-2 py-0.5 bg-slate-100 rounded border border-slate-200">{{ $rental->car->plate_number }}</span></div>
                        <div>{{ $rental->car->transmission }} &bull; {{ $rental->car->fuel_type }} &bull; {{ $rental->car->seating_capacity }} Kursi</div>
                        @if($rental->driver)
                            <div class="pt-2 text-emerald-700 font-semibold border-t border-slate-100 flex items-center gap-1.5">
                                <i class="fa-solid fa-id-card-clip"></i> Driver: {{ $rental->driver->name }} ({{ $rental->driver->phone }})
                            </div>
                        @else
                            <div class="pt-2 text-slate-400 font-medium border-t border-slate-100">Layanan: Lepas Kunci</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Box Durasi, Jaminan & Lokasi -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4 text-xs">
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-amber-500"></i> Durasi, Lokasi & Berkas Jaminan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div>
                        <span class="text-slate-400 uppercase text-[10px] font-bold block">Jadwal Mulai</span>
                        <span class="font-extrabold text-slate-800 text-xs">{{ $rental->start_date->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 uppercase text-[10px] font-bold block">Jadwal Selesai</span>
                        <span class="font-extrabold text-slate-800 text-xs">{{ $rental->end_date->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 uppercase text-[10px] font-bold block">Total Durasi</span>
                        <span class="font-extrabold text-blue-600 text-xs">{{ $rental->total_days }} Hari Penuh</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-slate-600">
                    <div><strong>Titik Pengambilan:</strong> {{ $rental->pickup_location }}</div>
                    <div><strong>Titik Pengembalian:</strong> {{ $rental->dropoff_location }}</div>
                    <div><strong>Bentuk Jaminan:</strong> {{ $rental->guarantee_type }}</div>
                    @if($rental->guarantee_file)
                        <div>
                            <strong>Foto Jaminan:</strong>
                            <a href="{{ asset('storage/' . $rental->guarantee_file) }}" target="_blank" class="text-blue-600 font-bold hover:underline ml-1">Lihat Berkas <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></a>
                        </div>
                    @endif
                </div>

                @if($rental->notes)
                    <div class="p-3 bg-slate-50 rounded-xl text-slate-600 italic">
                        <strong>Catatan:</strong> {{ $rental->notes }}
                    </div>
                @endif
            </div>

            <!-- Status Pengembalian Jika Sudah Diproses -->
            @if($rental->returnRecord)
                <div class="bg-emerald-50/60 p-6 rounded-3xl border border-emerald-200/80 shadow-sm space-y-3 text-xs text-emerald-900">
                    <h3 class="font-extrabold text-sm uppercase tracking-wider flex items-center justify-between">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-600"></i> Unit Telah Dikembalikan</span>
                        <span class="px-2.5 py-1 bg-emerald-600 text-white rounded-lg text-[10px]">Pemeriksaan Selesai</span>
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <span class="text-emerald-700 text-[10px] uppercase font-bold block">Waktu Kembali Aktual</span>
                            <span class="font-bold">{{ $rental->returnRecord->actual_return_date->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-emerald-700 text-[10px] uppercase font-bold block">Keterlambatan</span>
                            <span class="font-bold">{{ $rental->returnRecord->delay_hours }} Jam (Denda: Rp {{ number_format($rental->returnRecord->delay_penalty, 0, ',', '.') }})</span>
                        </div>
                        <div>
                            <span class="text-emerald-700 text-[10px] uppercase font-bold block">Kondisi Fisik</span>
                            <span class="font-bold capitalize">{{ str_replace('_', ' ', $rental->returnRecord->condition_status) }}</span>
                        </div>
                        <div>
                            <span class="text-emerald-700 text-[10px] uppercase font-bold block">Total Denda Ditagih</span>
                            <span class="font-black text-rose-600">Rp {{ number_format($rental->returnRecord->total_penalty, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Kolom Kanan: Rincian Keuangan & Ubah Status -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Box Ubah Status Transaksi -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4 text-xs">
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider">Update Status Sewa</h3>
                <form action="{{ route('admin.rentals.status', $rental->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="menunggu_konfirmasi" {{ $rental->status == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="dikonfirmasi" {{ $rental->status == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi (Booking Sah)</option>
                        <option value="sedang_berjalan" {{ $rental->status == 'sedang_berjalan' ? 'selected' : '' }}>Sedang Berjalan (Unit Diambil)</option>
                        <option value="selesai" {{ $rental->status == 'selesai' ? 'selected' : '' }}>Selesai (Dikembalikan)</option>
                        <option value="dibatalkan" {{ $rental->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition">
                        Update Status Sekarang
                    </button>
                </form>
            </div>

            <!-- Box Tagihan & Pembayaran -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4 text-xs">
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider flex items-center justify-between">
                    <span>Rincian Pembayaran</span>
                    <span class="text-blue-600 font-black">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                </h3>

                <div class="space-y-2 py-2 border-y border-slate-100 text-slate-600">
                    <div class="flex justify-between">
                        <span>Biaya Unit Mobil:</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($rental->car_cost, 0, ',', '.') }}</span>
                    </div>
                    @if($rental->driver_cost > 0)
                        <div class="flex justify-between">
                            <span>Biaya Jasa Sopir:</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($rental->driver_cost, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($rental->discount_amount > 0)
                        <div class="flex justify-between text-emerald-600 font-semibold">
                            <span>Potongan Diskon:</span>
                            <span>-Rp {{ number_format($rental->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between pt-2 border-t border-slate-100 font-bold text-slate-900">
                        <span>Total Tagihan:</span>
                        <span class="text-blue-600">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-emerald-600 font-bold">
                        <span>Sudah Dibayar (Valid):</span>
                        <span>Rp {{ number_format($rental->totalPaid(), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-rose-600 font-bold">
                        <span>Sisa Kekurangan:</span>
                        <span>Rp {{ number_format($rental->remaining_balance, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Histori Pembayaran -->
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">Riwayat Pembayaran Masuk</span>
                    <div class="space-y-2">
                        @forelse($rental->payments as $pay)
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-slate-800 uppercase text-[10px] block">{{ $pay->type }} &bull; {{ $pay->method }}</span>
                                    <span class="text-slate-900 font-black">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('admin.payments.show', $pay->id) }}" class="px-2 py-0.5 rounded text-[10px] font-bold
                                        @if($pay->status === 'diterima') bg-emerald-100 text-emerald-800
                                        @elseif($pay->status === 'menunggu_konfirmasi') bg-amber-100 text-amber-800
                                        @else bg-rose-100 text-rose-800 @endif">
                                        {{ $pay->status }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-slate-400 text-xs">Belum ada pembayaran dicatat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

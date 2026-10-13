@extends('layouts.admin')

@section('title', 'Buat Transaksi Sewa Baru - Admin Kasir')
@section('page_title', 'Form Pembuatan Sewa Mobil (Kasir)')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.rentals.store') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <!-- Pelanggan & Unit Mobil -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Pelanggan</label>
                    <select name="user_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">-- Pilih Akun Pelanggan --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Unit Mobil Tersedia</label>
                    <select name="car_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">-- Pilih Mobil --</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->name }} [{{ $car->plate_number }}] - Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/hari</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Sopir & Periode -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Pilihan Sopir (Opsional)</label>
                    <select name="driver_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="">Lepas Kunci (Tanpa Sopir)</option>
                        @foreach($drivers as $d)
                            <option value="{{ $d->id }}">{{ $d->name }} (+Rp {{ number_format($d->daily_rate, 0, ',', '.') }}/hari)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Mulai Sewa</label>
                    <input type="datetime-local" name="start_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Selesai Sewa</label>
                    <input type="datetime-local" name="end_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <!-- Diskon & DP -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Potongan Diskon (Rp)</label>
                    <input type="number" name="discount_amount" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Uang Muka / DP Dibayar (Rp)</label>
                    <input type="number" name="down_payment" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-emerald-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Status Awal</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold">
                        <option value="dikonfirmasi">Dikonfirmasi (Booking Sah)</option>
                        <option value="sedang_berjalan">Sedang Berjalan (Unit Diambil)</option>
                        <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                    </select>
                </div>
            </div>

            <!-- Jaminan & Lokasi -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Jaminan Ditahan</label>
                    <input type="text" name="guarantee_type" required value="KTP Asli" placeholder="KTP Asli / STNK Motor" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Ambil Unit</label>
                    <input type="text" name="pickup_location" required value="Kantor PKD Rental Mobil" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Kembali</label>
                    <input type="text" name="dropoff_location" required value="Kantor PKD Rental Mobil" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Transaksi</label>
                <textarea name="notes" rows="2" placeholder="Catatan opsional..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.rentals.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition">
                    Simpan Transaksi Sewa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

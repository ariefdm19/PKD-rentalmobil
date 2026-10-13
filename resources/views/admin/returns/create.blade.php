@extends('layouts.admin')

@section('title', 'Proses Pengembalian Mobil - Admin')
@section('page_title', 'Form Pemeriksaan Pengembalian & Denda')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.returns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf

            <!-- Pilih Rental Aktif -->
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Transaksi Sewa Yang Dikembalikan</label>
                <select name="rental_id" id="rental_select" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">-- Pilih Transaksi Rental --</option>
                    @foreach($activeRentals as $r)
                        <option value="{{ $r->id }}" 
                            data-code="{{ $r->rental_code }}" 
                            data-end="{{ $r->end_date->format('Y-m-d\TH:i') }}" 
                            data-penalty-rate="{{ $r->car->penalty_per_hour }}"
                            {{ (isset($selectedRental) && $selectedRental->id == $r->id) ? 'selected' : '' }}>
                            {{ $r->rental_code }} - {{ $r->car->name }} ({{ $r->car->plate_number }}) - Penyewa: {{ $r->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal & Jam Pengembalian Aktual -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Waktu Pengembalian Aktual</label>
                    <input type="datetime-local" name="actual_return_date" id="actual_return_date" required value="{{ date('Y-m-d\TH:i') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <span class="text-[10px] text-slate-400 mt-1 block">Sistem akan menghitung keterlambatan jam dan denda secara otomatis.</span>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Level Bahan Bakar Saat Kembali</label>
                    <select name="fuel_level_return" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs">
                        <option value="Penuh (Full)">Penuh (Full Tank)</option>
                        <option value="3/4 Tangki">3/4 Tangki</option>
                        <option value="1/2 Tangki">1/2 Tangki</option>
                        <option value="1/4 Tangki">1/4 Tangki</option>
                        <option value="Kosong / Indikator Menyala">Kosong / Menipis</option>
                    </select>
                </div>
            </div>

            <!-- Kondisi Fisik & Foto -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Kondisi Fisik & Body Mobil</label>
                    <select name="condition_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs">
                        <option value="sangat_baik">Sangat Baik (Mulus Bersih)</option>
                        <option value="baik">Baik (Wajar Pemakaian)</option>
                        <option value="baret_ringan">Baret Ringan / Tergores Halus</option>
                        <option value="rusak_sedang">Penyok / Kerusakan Sedang</option>
                        <option value="rusak_berat">Rusak Berat / Perlu Bengkel Body Repair</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Dokumentasi Kondisi (Opsional)</label>
                    <input type="file" name="condition_photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700">
                </div>
            </div>

            <!-- Input Denda Tambahan -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Denda Kerusakan / Lecet (Rp)</label>
                    <input type="number" name="damage_penalty" id="damage_penalty" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-rose-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Denda BBM Kurang (Rp)</label>
                    <input type="number" name="fuel_penalty" id="fuel_penalty" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-rose-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Denda Lainnya / Cuci (Rp)</label>
                    <input type="number" name="other_penalty" id="other_penalty" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-rose-600 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Pemeriksa / Kerusakan</label>
                <textarea name="condition_notes" rows="2" placeholder="Catatan goresan bumper depan, kebersihan kabin..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">Status Pembayaran Denda / Pelunasan</label>
                <select name="payment_status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold">
                    <option value="lunas">Lunas (Langsung Dibayar di Kasir)</option>
                    <option value="belum_lunas">Belum Lunas (Masuk Piutang)</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.returns.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow-md shadow-emerald-600/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-check"></i> Selesaikan Pengembalian & Rilis Mobil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Detail Pengembalian - ' . $return->rental->rental_code)
@section('page_title', 'Hasil Pemeriksaan Pengembalian')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6 text-xs">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-slate-100 gap-4">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">No. Transaksi Sewa:</span>
                <h2 class="text-xl font-mono font-black text-blue-600">{{ $return->rental->rental_code }}</h2>
                <div class="text-slate-500 mt-1">Petugas Pemeriksa: <strong>{{ $return->inspector->name ?? 'Admin Lapangan' }}</strong></div>
            </div>
            <span class="px-3.5 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl font-bold uppercase text-[11px]">
                Unit Sukses Dikembalikan
            </span>
        </div>

        <!-- Ringkasan Unit -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 bg-slate-50 rounded-2xl border border-slate-100">
            <div>
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Armada Mobil</span>
                <span class="font-extrabold text-slate-900 text-sm">{{ $return->rental->car->name }}</span>
                <div class="font-mono text-slate-500">{{ $return->rental->car->plate_number }}</div>
            </div>
            <div>
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Penyewa</span>
                <span class="font-extrabold text-slate-900 text-sm">{{ $return->rental->user->name }}</span>
                <div class="text-slate-500">{{ $return->rental->user->phone }}</div>
            </div>
        </div>

        <!-- Detail Waktu & Denda -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-1">
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Jadwal Selesai</span>
                <span class="font-bold text-slate-800">{{ $return->rental->end_date->translatedFormat('d M Y, H:i') }}</span>
            </div>
            <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-1">
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Pengembalian Aktual</span>
                <span class="font-bold text-slate-800">{{ $return->actual_return_date->translatedFormat('d M Y, H:i') }}</span>
            </div>
            <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-1">
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Keterlambatan</span>
                <span class="font-bold {{ $return->delay_hours > 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $return->delay_hours }} Jam</span>
            </div>
        </div>

        <!-- Rincian Denda -->
        <div class="p-5 bg-rose-50/50 rounded-2xl border border-rose-100 space-y-2">
            <h4 class="font-bold text-rose-900 uppercase tracking-wider text-[11px] mb-2">Rincian Penalti & Denda</h4>
            <div class="flex justify-between text-slate-600">
                <span>Denda Keterlambatan ({{ $return->delay_hours }} Jam):</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($return->delay_penalty, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-600">
                <span>Denda Kerusakan / Lecet Fisik:</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($return->damage_penalty, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-600">
                <span>Denda Pengisian Bahan Bakar:</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($return->fuel_penalty, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-slate-600">
                <span>Denda Kebersihan / Lainnya:</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($return->other_penalty, 0, ',', '.') }}</span>
            </div>
            <div class="pt-2 border-t border-rose-200 flex justify-between text-sm font-extrabold text-rose-800">
                <span>Total Denda:</span>
                <span class="text-base">Rp {{ number_format($return->total_penalty, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($return->condition_photo)
            <div>
                <span class="font-bold text-slate-700 uppercase tracking-wider block mb-2">Dokumentasi Foto Kondisi</span>
                <img src="{{ asset('storage/' . $return->condition_photo) }}" class="max-w-md h-52 object-cover rounded-2xl border border-slate-200 shadow-sm">
            </div>
        @endif

        <div class="flex justify-between items-center pt-4 border-t border-slate-100">
            <a href="{{ route('admin.returns.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
            <a href="{{ route('admin.rentals.show', $return->rental_id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition">
                Lihat Detail Transaksi Sewa
            </a>
        </div>
    </div>
</div>
@endsection

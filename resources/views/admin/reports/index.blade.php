@extends('layouts.admin')

@section('title', 'Laporan Keuangan & Laba Rugi - Admin')
@section('page_title', 'Laporan Keuangan & Kinerja Bisnis Rental')

@section('content')
<div class="space-y-8">
    <!-- Filter Periode & Cetak -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>
            <div class="pt-5">
                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-2">
                    <i class="fa-solid fa-filter"></i> Filter Periode
                </button>
            </div>
        </form>

        <div class="pt-5 sm:pt-0">
            <a href="{{ route('admin.reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Laporan Resmi
            </a>
        </div>
    </div>

    <!-- Ringkasan Laba Bersih & Arus Kas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pemasukan Sewa Mobil</span>
            <div class="text-xl font-black text-blue-600">Rp {{ number_format($totalRentalIncome, 0, ',', '.') }}</div>
            <span class="text-[11px] text-slate-400">{{ $payments->count() }} transaksi pembayaran</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pemasukan Denda Penalti</span>
            <div class="text-xl font-black text-amber-600">Rp {{ number_format($totalPenalties, 0, ',', '.') }}</div>
            <span class="text-[11px] text-slate-400">Keterlambatan & lecet fisik</span>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Biaya Servis & Perawatan</span>
            <div class="text-xl font-black text-rose-600">Rp {{ number_format($totalMaintenanceCost, 0, ',', '.') }}</div>
            <span class="text-[11px] text-slate-400">{{ $maintenances->count() }} kali pengerjaan bengkel</span>
        </div>

        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white p-6 rounded-3xl shadow-lg shadow-emerald-600/20 space-y-1">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-100">Laba Bersih Operasional</span>
            <div class="text-2xl font-black">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
            <span class="text-[11px] text-emerald-200 font-medium">Margin: {{ $grossRevenue > 0 ? round(($netProfit / $grossRevenue) * 100, 1) : 0 }}%</span>
        </div>
    </div>

    <!-- Mobil Paling Menguntungkan -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <h3 class="font-extrabold text-base text-slate-900 mb-4">Unit Armada Paling Populer (Periode Ini)</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($popularCars as $pop)
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4 text-xs">
                    <img src="{{ $pop->car->image ? (str_starts_with($pop->car->image, 'http') ? $pop->car->image : asset('storage/' . $pop->car->image)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80' }}" class="w-16 h-12 object-cover rounded-xl shadow-sm">
                    <div class="flex-1">
                        <div class="font-bold text-slate-900">{{ $pop->car->name }}</div>
                        <div class="text-slate-500 font-mono text-[11px]">{{ $pop->car->plate_number }}</div>
                        <div class="text-blue-600 font-extrabold mt-1">{{ $pop->total_rentals }}x Disewa &bull; Rp {{ number_format($pop->total_earnings, 0, ',', '.') }}</div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-6 text-slate-400 text-xs">Belum ada transaksi di rentang tanggal ini.</div>
            @endforelse
        </div>
    </div>

    <!-- Rincian Buku Kas Masuk & Keluar -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-extrabold text-base text-slate-900">Rincian Penerimaan Dana Masuk</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-6">Tanggal & Waktu</th>
                        <th class="py-3 px-6">Kode Bayar</th>
                        <th class="py-3 px-6">Penyewa</th>
                        <th class="py-3 px-6">Armada</th>
                        <th class="py-3 px-6">Metode</th>
                        <th class="py-3 px-6 text-right">Nominal Masuk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $p)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-6 text-slate-600">{{ $p->paid_at ? $p->paid_at->translatedFormat('d M Y, H:i') : $p->created_at->translatedFormat('d M Y, H:i') }}</td>
                            <td class="py-3 px-6 font-mono font-bold text-blue-600">{{ $p->payment_code }}</td>
                            <td class="py-3 px-6 font-semibold text-slate-800">{{ $p->rental->user->name }}</td>
                            <td class="py-3 px-6 text-slate-600">{{ $p->rental->car->name }}</td>
                            <td class="py-3 px-6 uppercase text-slate-500 text-[10px]">{{ str_replace('_', ' ', $p->method) }}</td>
                            <td class="py-3 px-6 text-right font-black text-emerald-600">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada penerimaan sewa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

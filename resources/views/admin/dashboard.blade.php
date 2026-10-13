@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan - Admin PKD Rental')
@section('page_title', 'Ringkasan Operasional & Keuangan')

@section('content')
<div class="space-y-8">
    
    <!-- Top Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pendapatan Masuk -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Total Pendapatan</span>
                <div class="text-xl font-extrabold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <span class="text-[11px] text-emerald-600 font-semibold block">Bulan ini: Rp {{ number_format($monthRevenue, 0, ',', '.') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <!-- Total Armada Mobil -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Status Armada</span>
                <div class="text-xl font-extrabold text-slate-900">{{ $totalCars }} Unit</div>
                <div class="text-[11px] text-slate-700 flex gap-2 font-medium">
                    <span class="text-emerald-700 font-semibold">{{ $carsAvailable }} Siap</span> &bull;
                    <span class="text-amber-700 font-semibold">{{ $carsRented }} Jalan</span> &bull;
                    <span class="text-rose-700 font-semibold">{{ $carsMaintenance }} Bengkel</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-car-side"></i>
            </div>
        </div>

        <!-- Transaksi Aktif -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Sewa Berjalan</span>
                <div class="text-xl font-extrabold text-slate-900">{{ $rentalsActive }} Unit</div>
                <span class="text-[11px] text-amber-700 font-semibold block">{{ $rentalsPending }} Pesanan Baru Menunggu</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <!-- Sopir & Pengemudi -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Tim Driver</span>
                <div class="text-xl font-extrabold text-slate-900">{{ $totalDrivers }} Orang</div>
                <span class="text-[11px] text-emerald-700 font-semibold block">{{ $driversAvailable }} Driver Siap Tugas</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-id-badge"></i>
            </div>
        </div>
    </div>

    <!-- Chart & Quick Status Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Monthly Revenue Chart -->
        <div class="lg:col-span-8 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-extrabold text-base text-slate-900">Grafik Omset Pembayaran Sewa ({{ date('Y') }})</h3>
                    <p class="text-xs text-slate-600">Statistik penerimaan dana sewa yang telah diverifikasi</p>
                </div>
                <span class="px-3 py-1 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Tahun {{ date('Y') }}</span>
            </div>
            <div class="h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Pending Payment Approvals -->
        <div class="lg:col-span-4 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-extrabold text-sm text-slate-900">Verifikasi Pembayaran</h3>
                    <a href="{{ route('admin.payments.index') }}" class="text-xs text-blue-600 font-bold hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($pendingPayments as $pPay)
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-xs">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono font-bold text-blue-600">{{ $pPay->payment_code }}</span>
                                <span class="font-extrabold text-slate-900">Rp {{ number_format($pPay->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="text-[11px] text-slate-500 truncate">{{ $pPay->rental->user->name }} &bull; {{ $pPay->rental->car->name }}</div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 capitalize">{{ $pPay->type }} ({{ $pPay->method }})</span>
                                <a href="{{ route('admin.payments.show', $pPay->id) }}" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-[10px]">Periksa</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            <i class="fa-solid fa-circle-check text-2xl text-emerald-400 mb-2"></i>
                            <p>Tidak ada pembayaran tertunda saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Total Denda Masuk:</span>
                <span class="font-bold text-rose-600">Rp {{ number_format($penaltiesTotal, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-base text-slate-900">Transaksi Sewa Terbaru</h3>
                <p class="text-xs text-slate-400">5 transaksi yang baru saja masuk ke sistem rental</p>
            </div>
            <a href="{{ route('admin.rentals.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                Lihat Semua Transaksi
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-3.5 px-6">Kode Rental</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Armada</th>
                        <th class="py-3.5 px-6">Total Biaya</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentRentals as $rental)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                {{ $rental->rental_code }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $rental->user->name }}</div>
                                <div class="text-[11px] text-slate-400">{{ $rental->user->phone }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800">{{ $rental->car->name }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $rental->car->plate_number }}</div>
                            </td>
                            <td class="py-4 px-6 font-extrabold text-slate-900">
                                Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold capitalize
                                    @if($rental->status === 'selesai') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($rental->status === 'sedang_berjalan') bg-indigo-50 text-indigo-700 border border-indigo-200
                                    @elseif($rental->status === 'dikonfirmasi') bg-blue-50 text-blue-700 border border-blue-200
                                    @elseif($rental->status === 'menunggu_konfirmasi') bg-amber-50 text-amber-700 border border-amber-200
                                    @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                                    {{ str_replace('_', ' ', $rental->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.rentals.show', $rental->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg font-bold transition inline-flex items-center gap-1">
                                    Buka <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartMonths),
            datasets: [{
                label: 'Omset Rental (Rp)',
                data: @json($chartIncome),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#1d4ed8',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000).toLocaleString('id-ID') + 'k';
                        }
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
@endsection

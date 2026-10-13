<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan & Laba Rugi - {{ $companyName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-slate-100 p-8 text-slate-900 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-md border border-slate-200">
        <div class="no-print flex justify-end gap-3 mb-8">
            <button onclick="window.print()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan (Print / PDF)
            </button>
            <button onclick="window.close()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold">
                Tutup
            </button>
        </div>

        <!-- Kop Surat -->
        <div class="border-b-2 border-slate-900 pb-4 mb-6 text-center">
            <h1 class="text-2xl font-black tracking-tight uppercase">{{ $companyName }}</h1>
            <h2 class="text-sm font-bold text-slate-700 mt-1">LAPORAN REKAPITULASI LABA RUGI OPERASIONAL</h2>
            <p class="text-xs text-slate-500 mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
        </div>

        <!-- Tabel Ringkasan Laba Rugi -->
        <div class="mb-8">
            <table class="w-full text-xs border border-slate-300">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                        <th class="p-3 text-left">Komponen Keuangan</th>
                        <th class="p-3 text-right">Jumlah Transaksi</th>
                        <th class="p-3 text-right">Total Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr>
                        <td class="p-3 font-semibold text-slate-800">1. Penerimaan Sewa Armada (Omset Utama)</td>
                        <td class="p-3 text-right">{{ $payments->count() }} Pembayaran</td>
                        <td class="p-3 text-right font-bold text-blue-700">Rp {{ number_format($totalRentalIncome, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-semibold text-slate-800">2. Penerimaan Denda & Penalti Pengembalian</td>
                        <td class="p-3 text-right">{{ $returns->count() }} Pengembalian</td>
                        <td class="p-3 text-right font-bold text-amber-700">Rp {{ number_format($totalPenalties, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-slate-50 font-bold">
                        <td class="p-3 text-slate-900">TOTAL PENDAPATAN KOTOR (A)</td>
                        <td class="p-3 text-right">-</td>
                        <td class="p-3 text-right text-emerald-700 font-extrabold text-sm">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-semibold text-slate-800">3. Beban Operasional: Servis & Perawatan Armada (B)</td>
                        <td class="p-3 text-right">{{ $maintenances->count() }} Servis</td>
                        <td class="p-3 text-right font-bold text-rose-700">Rp {{ number_format($totalMaintenanceCost, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-slate-900 text-white font-black text-sm">
                        <td class="p-3 uppercase">LABA BERSIH BERSIH OPERASIONAL (A - B)</td>
                        <td class="p-3 text-right">-</td>
                        <td class="p-3 text-right text-emerald-400">Rp {{ number_format($netProfit, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan Pengesahan -->
        <div class="grid grid-cols-2 gap-8 text-center text-xs pt-10">
            <div>
                <p class="text-slate-500 mb-16">Dibuat Oleh,</p>
                <p class="font-extrabold text-slate-900 border-b border-slate-400 inline-block px-8 pb-1">Bagian Keuangan & Kasir</p>
            </div>
            <div>
                <p class="text-slate-500 mb-16">Mengetahui & Menyetujui,</p>
                <p class="font-extrabold text-slate-900 border-b border-slate-400 inline-block px-8 pb-1">Direktur / Owner PKD Rental</p>
            </div>
        </div>
    </div>
</body>
</html>

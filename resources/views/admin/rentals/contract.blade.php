<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perjanjian Sewa - {{ $rental->rental_code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-slate-100 p-8 text-slate-900 font-sans">
    <div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-md border border-slate-200">
        <!-- Print Trigger -->
        <div class="no-print flex justify-end gap-3 mb-8">
            <button onclick="window.print()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Dokumen Kontrak (Print)
            </button>
            <button onclick="window.close()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold">
                Tutup
            </button>
        </div>

        <!-- Header Kop Surat -->
        <div class="border-b-2 border-slate-900 pb-4 mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">{{ $settings['company_name'] }}</h1>
                <p class="text-xs text-slate-600 mt-1">{{ $settings['company_address'] }}</p>
                <p class="text-xs text-slate-600">Telp: {{ $settings['company_phone'] }} | Email: {{ $settings['company_email'] }}</p>
            </div>
            <div class="text-right">
                <span class="text-xs font-bold uppercase text-slate-400 block">Surat Perjanjian Sewa</span>
                <span class="font-mono text-base font-black text-blue-700">{{ $rental->rental_code }}</span>
                <span class="text-[11px] text-slate-500 block mt-1">Tanggal: {{ $rental->created_at->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <!-- Pihak Terkait -->
        <div class="grid grid-cols-2 gap-6 text-xs mb-6">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-1">
                <span class="font-bold uppercase tracking-wider text-slate-400 block text-[10px]">Pihak Pertama (Penyedia Unit)</span>
                <div class="font-extrabold text-sm text-slate-900">{{ $settings['company_name'] }}</div>
                <div>Perwakilan: Staff Administrasi Operasional</div>
                <div>Kontak: {{ $settings['company_phone'] }}</div>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-1">
                <span class="font-bold uppercase tracking-wider text-slate-400 block text-[10px]">Pihak Kedua (Penyewa)</span>
                <div class="font-extrabold text-sm text-slate-900">{{ $rental->user->name }}</div>
                <div>NIK: {{ $rental->user->nik ?: '-' }} | Telp: {{ $rental->user->phone }}</div>
                <div>Alamat: {{ $rental->user->address ?: '-' }}</div>
            </div>
        </div>

        <!-- Rincian Armada & Sewa -->
        <div class="mb-6">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Rincian Kendaraan & Jadwal Sewa</h3>
            <table class="w-full text-xs border border-slate-200">
                <tbody class="divide-y divide-slate-200">
                    <tr class="bg-slate-50">
                        <td class="p-2.5 font-bold text-slate-600 w-1/3">Nama Armada / Plat Polisi</td>
                        <td class="p-2.5 font-bold text-slate-900">{{ $rental->car->name }} &bull; Plat: {{ $rental->car->plate_number }}</td>
                    </tr>
                    <tr>
                        <td class="p-2.5 font-bold text-slate-600">Durasi Sewa</td>
                        <td class="p-2.5">{{ $rental->total_days }} Hari Penuh ({{ $rental->start_date->translatedFormat('d M Y, H:i') }} s/d {{ $rental->end_date->translatedFormat('d M Y, H:i') }})</td>
                    </tr>
                    <tr class="bg-slate-50">
                        <td class="p-2.5 font-bold text-slate-600">Layanan Tambahan</td>
                        <td class="p-2.5">{{ $rental->driver ? 'Dengan Sopir (' . $rental->driver->name . ')' : 'Lepas Kunci (Menyetir Sendiri)' }}</td>
                    </tr>
                    <tr>
                        <td class="p-2.5 font-bold text-slate-600">Jaminan Ditahan</td>
                        <td class="p-2.5">{{ $rental->guarantee_type }}</td>
                    </tr>
                    <tr class="bg-slate-50">
                        <td class="p-2.5 font-bold text-slate-600">Titik Serah Terima</td>
                        <td class="p-2.5">Ambil: {{ $rental->pickup_location }} | Kembali: {{ $rental->dropoff_location }}</td>
                    </tr>
                    <tr>
                        <td class="p-2.5 font-bold text-slate-600">Total Biaya Sewa</td>
                        <td class="p-2.5 font-extrabold text-blue-700 text-sm">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Ketentuan & Pasal -->
        <div class="text-[11px] text-slate-600 mb-8 space-y-2">
            <h4 class="font-bold text-slate-800 uppercase tracking-wider text-[10px]">Ketentuan & Tata Tertib Sewa:</h4>
            <div class="whitespace-pre-line leading-relaxed pl-2 border-l-2 border-slate-300">
                {{ $settings['rental_terms'] }}
            </div>
        </div>

        <!-- Tanda Tangan -->
        <div class="grid grid-cols-2 gap-8 text-center text-xs pt-8 border-t border-slate-200">
            <div>
                <p class="font-semibold text-slate-500 mb-16">Pihak Pertama (Penyedia)</p>
                <p class="font-extrabold text-slate-900 border-b border-slate-400 inline-block px-8 pb-1">Petugas Operasional</p>
                <p class="text-[10px] text-slate-400 mt-1">{{ $settings['company_name'] }}</p>
            </div>
            <div>
                <p class="font-semibold text-slate-500 mb-16">Pihak Kedua (Penyewa)</p>
                <p class="font-extrabold text-slate-900 border-b border-slate-400 inline-block px-8 pb-1">{{ $rental->user->name }}</p>
                <p class="text-[10px] text-slate-400 mt-1">Penyewa Utama</p>
            </div>
        </div>
    </div>
</body>
</html>

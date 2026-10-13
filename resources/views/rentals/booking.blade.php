@extends('layouts.app')

@section('title', 'Form Sewa - ' . $car->name)

@section('content')
<div class="bg-slate-900 text-white py-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <h1 class="text-2xl font-extrabold tracking-tight">Formulir Booking Sewa Mobil</h1>
        <p class="text-slate-400 text-xs mt-1">Lengkapi data perjalanan dan jaminan identitas Anda di bawah ini.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
        
        <!-- Summary Banner -->
        <div class="p-6 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ $car->image ? (str_starts_with($car->image, 'http') ? $car->image : asset('storage/' . $car->image)) : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $car->name }}" class="w-20 h-16 object-cover rounded-xl shadow-sm">
                <div>
                    <span class="text-[11px] font-bold text-blue-600 uppercase">{{ $car->brand }}</span>
                    <h3 class="text-base font-extrabold text-slate-900">{{ $car->name }}</h3>
                    <div class="text-xs text-slate-500">{{ $car->transmission }} &bull; {{ $car->seating_capacity }} Kursi &bull; Plat: {{ $car->plate_number }}</div>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-[10px] text-slate-400 font-bold uppercase">Harga Sewa Unit</span>
                <div class="text-lg font-black text-blue-600" id="car-rate" data-rate="{{ $car->price_per_day }}">
                    Rp {{ number_format($car->price_per_day, 0, ',', '.') }} <span class="text-xs text-slate-500 font-normal">/hari</span>
                </div>
            </div>
        </div>

        <form action="{{ route('rentals.booking.post', $car->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Identitas Penyewa -->
            <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex items-center justify-between">
                <div>
                    <div class="text-xs text-blue-900 font-bold">Data Pemesan (Akun Anda)</div>
                    <div class="text-sm font-semibold text-slate-800">{{ $user->name }} ({{ $user->phone }})</div>
                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                </div>
                <span class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs font-semibold">Pelanggan Terverifikasi</span>
            </div>

            <!-- Periode Sewa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal & Waktu Mulai Sewa</label>
                    <input type="datetime-local" name="start_date" id="start_date" required 
                           min="{{ date('Y-m-d\TH:i') }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal & Waktu Selesai</label>
                    <input type="datetime-local" name="end_date" id="end_date" required 
                           min="{{ date('Y-m-d\TH:i') }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <!-- Opsi Layanan Sopir -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilihan Layanan Sopir</label>
                <select name="driver_id" id="driver_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="" data-rate="0">Lepas Kunci (Tanpa Sopir - Menyetir Sendiri)</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}" data-rate="{{ $driver->daily_rate }}">
                            Paket Sopir: {{ $driver->name }} (+Rp {{ number_format($driver->daily_rate, 0, ',', '.') }}/hari)
                        </option>
                    @endforeach
                </select>
                <span class="text-[11px] text-slate-400 mt-1 block">Sopir bertugas selama masa durasi sewa berlangsung. Biaya makan sopir fleksibel atau ditanggung penyewa.</span>
            </div>

            <!-- Jaminan Identitas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Jaminan Asli Dititipkan</label>
                    <select name="guarantee_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        <option value="KTP Asli">KTP Elektronik Asli</option>
                        <option value="SIM A & KK">SIM A & Fotokopi KK</option>
                        <option value="Sepeda Motor + STNK">Sepeda Motor + STNK (Titip Gudang)</option>
                        <option value="Paspor Asli">Paspor Asli (Untuk WNA/Ekspat)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto / Scan Identitas (Opsional)</label>
                    <input type="file" name="guarantee_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <!-- Lokasi Antar Jemput -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Pengambilan / Antar Unit</label>
                    <input type="text" name="pickup_location" required value="Kantor PKD Rental Mobil" placeholder="Misal: Bandara Husein / Stasiun / Alamat Rumah" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Lokasi Pengembalian Unit</label>
                    <input type="text" name="dropoff_location" required value="Kantor PKD Rental Mobil" placeholder="Misal: Kantor Rental / Titik Temu" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Perjalanan (Opsional)</label>
                <textarea name="notes" rows="2" placeholder="Tujuan rute kota, permintaan child car seat, atau waktu antar khusus..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none"></textarea>
            </div>

            <!-- Ringkasan Estimasi Biaya Otomatis -->
            <div class="p-6 bg-slate-900 text-white rounded-2xl space-y-3">
                <div class="text-xs font-bold uppercase tracking-wider text-blue-400">Rincian Estimasi Biaya Sewa</div>
                <div class="flex justify-between text-xs text-slate-300">
                    <span>Estimasi Durasi:</span>
                    <span id="summary-days" class="font-bold text-white">1 Hari (24 Jam)</span>
                </div>
                <div class="flex justify-between text-xs text-slate-300">
                    <span>Biaya Unit Mobil:</span>
                    <span id="summary-car-cost" class="font-bold text-white">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs text-slate-300">
                    <span>Biaya Layanan Sopir:</span>
                    <span id="summary-driver-cost" class="font-bold text-white">Rp 0</span>
                </div>
                <div class="pt-3 border-t border-slate-800 flex justify-between items-center text-sm font-extrabold">
                    <span class="text-slate-200">Total Biaya Sewa:</span>
                    <span id="summary-total" class="text-xl text-emerald-400 font-black">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                </div>
                <div class="text-[11px] text-slate-400 pt-1 flex items-center justify-between">
                    <span>Rekomendasi Uang Muka (DP 30%):</span>
                    <span id="summary-dp" class="font-bold text-blue-300">Rp {{ number_format(round($car->price_per_day * 0.3), 0, ',', '.') }}</span>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-600/30 transition transform active:scale-95 flex items-center justify-center gap-2">
                <i class="fa-solid fa-check-circle text-lg"></i> Konfirmasi Booking & Lanjut Pembayaran
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const carRate = parseFloat(document.getElementById('car-rate').getAttribute('data-rate'));
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const driverSelect = document.getElementById('driver_id');

    function calculateTotal() {
        let days = 1;
        if (startDateInput.value && endDateInput.value) {
            const start = new Date(startDateInput.value);
            const end = new Date(endDateInput.value);
            const diffTime = end - start;
            if (diffTime > 0) {
                days = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
            }
        }

        const selectedDriverOption = driverSelect.options[driverSelect.selectedIndex];
        const driverRate = parseFloat(selectedDriverOption.getAttribute('data-rate') || 0);

        const carCost = carRate * days;
        const driverCost = driverRate * days;
        const total = carCost + driverCost;
        const dp = Math.round(total * 0.3);

        document.getElementById('summary-days').innerText = days + ' Hari';
        document.getElementById('summary-car-cost').innerText = 'Rp ' + carCost.toLocaleString('id-ID');
        document.getElementById('summary-driver-cost').innerText = 'Rp ' + driverCost.toLocaleString('id-ID');
        document.getElementById('summary-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('summary-dp').innerText = 'Rp ' + dp.toLocaleString('id-ID');
    }

    startDateInput.addEventListener('change', calculateTotal);
    endDateInput.addEventListener('change', calculateTotal);
    driverSelect.addEventListener('change', calculateTotal);
</script>
@endpush
@endsection

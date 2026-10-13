<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PKD Rental Mobil - Sewa Mobil Terpercaya')</title>
    <!-- Tailwind CSS CDN & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Top Info Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center space-x-6">
                <span><i class="fa-solid fa-phone text-emerald-400 mr-2"></i>{{ \App\Models\Setting::get('company_phone', '0812-3456-7890') }}</span>
                <span><i class="fa-solid fa-envelope text-blue-400 mr-2"></i>{{ \App\Models\Setting::get('company_email', 'admin@rentalmobil.pkd') }}</span>
            </div>
            <div class="flex items-center space-x-4">
                <span><i class="fa-solid fa-location-dot text-rose-400 mr-2"></i>{{ \App\Models\Setting::get('company_address', 'Bandung, Jawa Barat') }}</span>
                <span class="text-slate-500">|</span>
                <span class="text-emerald-400 font-medium"><i class="fa-solid fa-circle-check mr-1"></i>Armada Terawat & Bersih</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="bg-white/95 backdrop-blur shadow-sm sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-gradient-to-tr from-blue-700 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25">
                        <i class="fa-solid fa-car-side text-2xl"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-xl tracking-tight text-slate-900 flex items-center gap-1.5">
                            PKD <span class="text-blue-600">Rental Mobil</span>
                        </div>
                        <div class="text-[11px] font-semibold text-slate-600 tracking-wider uppercase">Pintar Kreatif Digital</div>
                    </div>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center space-x-8 font-medium text-sm">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-blue-600' }} transition">Beranda</a>
                    <a href="{{ route('cars.catalog') }}" class="{{ request()->routeIs('cars.catalog*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-blue-600' }} transition">Katalog Mobil</a>
                    <a href="{{ route('home') }}#keunggulan" class="text-slate-600 hover:text-blue-600 transition">Keunggulan</a>
                    <a href="{{ route('home') }}#sopir" class="text-slate-600 hover:text-blue-600 transition">Layanan Sopir</a>
                    <a href="{{ route('home') }}#testimoni" class="text-slate-600 hover:text-blue-600 transition">Testimoni</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->isAdmin() || Auth::user()->isPetugas())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                                <i class="fa-solid fa-gauge-high text-blue-400"></i> Panel Admin
                            </a>
                        @endif
                        <a href="{{ route('customer.rentals.index') }}" class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                            <i class="fa-solid fa-receipt"></i> Sewa Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 text-slate-500 hover:text-rose-600 text-sm font-medium transition" title="Logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-blue-600 text-sm font-semibold transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-600/20 transition flex items-center gap-2">
                            <i class="fa-solid fa-user-plus text-xs"></i> Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 w-full mt-4">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                            <i class="fa-solid fa-car-side"></i>
                        </div>
                        <span class="font-extrabold text-xl text-white">PKD Rental Mobil</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Layanan rental mobil harian, mingguan, dan bulanan profesional. Unit armada keluaran terbaru dengan perawatan berkala dan pilihan pengemudi berpengalaman.
                    </p>
                    <div class="flex space-x-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-rose-600 hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://wa.me/{{ \App\Models\Setting::get('company_whatsapp', '6281234567890') }}" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-emerald-600 hover:text-white transition"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Navigasi Cepat</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition">Beranda</a></li>
                        <li><a href="{{ route('cars.catalog') }}" class="hover:text-blue-400 transition">Katalog Armada</a></li>
                        <li><a href="{{ route('customer.rentals.index') }}" class="hover:text-blue-400 transition">Riwayat Pemesanan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">Login Akun</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Metode Pembayaran</h3>
                    <p class="text-xs text-slate-400 mb-3">Mendukung transfer bank resmi, QRIS instan, dan tunai di lokasi kantor.</p>
                    <div class="space-y-2 text-xs text-slate-300">
                        <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/50">
                            <span class="text-blue-400 font-semibold">{{ \App\Models\Setting::get('bank_name', 'BCA') }}:</span> 
                            {{ \App\Models\Setting::get('bank_account_number', '8730129841') }} 
                            <span class="text-slate-400 block text-[11px]">a/n {{ \App\Models\Setting::get('bank_account_holder', 'PKD Rental Mobil') }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Kontak Layanan</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-rose-500 mt-1"></i>
                            <span>{{ \App\Models\Setting::get('company_address', 'Bandung, Jawa Barat') }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-emerald-400"></i>
                            <span>{{ \App\Models\Setting::get('company_phone', '0812-3456-7890') }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                            <span>+{{ \App\Models\Setting::get('company_whatsapp', '6281234567890') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} Pintar Kreatif Digital. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex space-x-6">
                    <span>Aplikasi Rental Mobil Siap Pakai & Komersial</span>
                    <span>Versi 1.0.0</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/{{ \App\Models\Setting::get('company_whatsapp', '6281234567890') }}?text=Halo%20Admin%20PKD%20Rental%20Mobil,%20saya%20ingin%20tanya%20sewa%20unit" target="_blank" class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-xl shadow-emerald-500/30 transition transform hover:scale-110">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
    </a>

    @stack('scripts')
</body>
</html>

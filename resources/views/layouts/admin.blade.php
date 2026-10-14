<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - PKD Rental Mobil')</title>
    <!-- Tailwind CSS CDN & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
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
<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col flex-shrink-0 z-30 shadow-xl transition-all">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/40">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-car-side text-xl"></i>
                </div>
                <div>
                    <div class="font-extrabold text-base text-white tracking-tight">PKD Rental</div>
                    <div class="text-[10px] text-blue-400 font-semibold uppercase tracking-wider">Control Panel</div>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto py-5 px-4 space-y-6">
            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Utama</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-400' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Operasional Rental</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.rentals.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.rentals*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-file-invoice w-5 text-center {{ request()->routeIs('admin.rentals*') ? 'text-white' : 'text-indigo-400' }}"></i>
                        <span>Transaksi Sewa</span>
                    </a>
                    <a href="{{ route('admin.returns.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.returns*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-car-tunnel w-5 text-center {{ request()->routeIs('admin.returns*') ? 'text-white' : 'text-emerald-400' }}"></i>
                        <span>Pengembalian & Denda</span>
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.payments*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-money-check-dollar w-5 text-center {{ request()->routeIs('admin.payments*') ? 'text-white' : 'text-amber-400' }}"></i>
                        <span>Verifikasi Pembayaran</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Armada & Petugas</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.cars.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.cars*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-car w-5 text-center {{ request()->routeIs('admin.cars*') ? 'text-white' : 'text-sky-400' }}"></i>
                        <span>Daftar Mobil</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.categories*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-layer-group w-5 text-center {{ request()->routeIs('admin.categories*') ? 'text-white' : 'text-purple-400' }}"></i>
                        <span>Kategori Mobil</span>
                    </a>
                    <a href="{{ route('admin.drivers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.drivers*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-id-card-clip w-5 text-center {{ request()->routeIs('admin.drivers*') ? 'text-white' : 'text-teal-400' }}"></i>
                        <span>Driver / Sopir</span>
                    </a>
                    <a href="{{ route('admin.maintenances.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.maintenances*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-wrench w-5 text-center {{ request()->routeIs('admin.maintenances*') ? 'text-white' : 'text-orange-400' }}"></i>
                        <span>Servis & Perawatan</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Laporan & Pengaturan</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.reports*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-chart-line w-5 text-center {{ request()->routeIs('admin.reports*') ? 'text-white' : 'text-emerald-400' }}"></i>
                        <span>Laporan Laba Rugi</span>
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-users-gear w-5 text-center {{ request()->routeIs('admin.users*') ? 'text-white' : 'text-cyan-400' }}"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.settings*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-sliders w-5 text-center {{ request()->routeIs('admin.settings*') ? 'text-white' : 'text-rose-400' }}"></i>
                            <span>Pengaturan Aplikasi</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Info Bottom -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="truncate max-w-[110px]">
                        <div class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-blue-400 font-medium capitalize">{{ Auth::user()->role }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 transition" title="Logout">
                        <i class="fa-solid fa-power-off text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold text-slate-800">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Web Publik
                </a>
                <div class="h-6 w-px bg-slate-200"></div>
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-semibold text-slate-800">{{ now()->translatedFormat('l, d F Y') }}</div>
                    <div class="text-[11px] text-emerald-600 font-medium"><i class="fa-solid fa-circle text-[8px] mr-1"></i>Sistem Online</div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6 sm:p-8 bg-slate-50">
            @if(session('success'))
                <div class="p-4 mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
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
                <div class="p-4 mb-6 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-6 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                    <div class="font-bold text-sm mb-1 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i> Mohon periksa kembali formulir:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <footer class="mt-12 pt-6 border-t border-slate-200 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} <a href="https://pintarkreatifdigital.com/" target="_blank" rel="noopener noreferrer" class="font-semibold text-slate-700 hover:text-blue-600 transition">Pintar Kreatif Digital</a>. Seluruh hak cipta dilindungi.
            </footer>
        </main>
    </div>

    @stack('scripts')
</body>
</html>

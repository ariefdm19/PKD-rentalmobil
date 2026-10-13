@extends('layouts.app')

@section('title', 'Masuk - PKD Rental Mobil')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="text-center">
            <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/30 text-2xl">
                <i class="fa-solid fa-key"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h2>
            <p class="mt-2 text-sm text-slate-500">Masuk ke akun rental mobil Anda</p>
        </div>

        <!-- Quick Demo Credentials Box -->
        <div class="bg-blue-50/80 border border-blue-200/60 rounded-2xl p-4 text-xs text-blue-900">
            <div class="font-bold flex items-center gap-1.5 mb-2 text-blue-800">
                <i class="fa-solid fa-circle-info text-blue-600"></i> Akun Demo Cepat (Siap Pakai):
            </div>
            <div class="grid grid-cols-2 gap-2 text-[11px]">
                <div class="bg-white p-2 rounded-lg border border-blue-100">
                    <span class="font-semibold block text-blue-700">Admin Utama:</span>
                    <span>admin@pkd.com</span><br>
                    <span class="text-slate-400">pass: admin123</span>
                </div>
                <div class="bg-white p-2 rounded-lg border border-blue-100">
                    <span class="font-semibold block text-emerald-700">Pelanggan Demo:</span>
                    <span>pelanggan@pkd.com</span><br>
                    <span class="text-slate-400">pass: pelanggan123</span>
                </div>
            </div>
        </div>

        <form class="mt-6 space-y-5" action="{{ route('login.post') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email', 'admin@pkd.com') }}" required 
                        class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                        placeholder="nama@email.com">
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input id="password" name="password" type="password" required 
                        class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                        placeholder="••••••••" value="admin123">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                    <label for="remember" class="ml-2 block text-xs font-medium text-slate-600">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-600/30 transition transform active:scale-95 flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Sekarang
            </button>
        </form>

        <div class="text-center text-xs text-slate-500 pt-2">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 ml-1">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection

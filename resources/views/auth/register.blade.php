@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan - PKD Rental Mobil')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="text-center">
            <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-500/30 text-2xl">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Baru</h2>
            <p class="mt-2 text-sm text-slate-500">Mulai sewa kendaraan impian Anda dengan cepat</p>
        </div>

        <form class="mt-6 space-y-4" action="{{ route('register.post') }}" method="POST">
            @csrf
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Sesuai KTP</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required 
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                    placeholder="Contoh: Muhammad Farhan">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                    placeholder="farhan@example.com">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required 
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                        placeholder="081234567890">
                </div>
                <div>
                    <label for="nik" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor NIK KTP</label>
                    <input id="nik" name="nik" type="text" value="{{ old('nik') }}" 
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                        placeholder="3273xxxxxxx">
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Domisili</label>
                <input id="address" name="address" type="text" value="{{ old('address') }}" 
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                    placeholder="Jl. Sukajadi No. 100, Bandung">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                <input id="password" name="password" type="password" required 
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                    placeholder="Minimal 6 karakter">
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required 
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" 
                    placeholder="Ketik ulang password">
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/30 transition transform active:scale-95 flex items-center justify-center gap-2 mt-4">
                <i class="fa-solid fa-check"></i> Selesaikan Pendaftaran
            </button>
        </form>

        <div class="text-center text-xs text-slate-500 pt-2">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 ml-1">Masuk di Sini</a>
        </div>
    </div>
</div>
@endsection

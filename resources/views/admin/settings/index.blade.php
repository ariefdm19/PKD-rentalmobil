@extends('layouts.admin')

@section('title', 'Pengaturan Usaha Rental - Admin')
@section('page_title', 'Pengaturan Profil & Rekening Rental')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <div>
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-store text-blue-600"></i> Informasi Usaha & Branding
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Usaha Rental</label>
                        <input type="text" name="company_name" required value="{{ old('company_name', $settings['company_name']) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Slogan / Tagline</label>
                        <input type="text" name="company_tagline" value="{{ old('company_tagline', $settings['company_tagline']) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-phone text-emerald-600"></i> Kontak Operasional
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon Kantor</label>
                        <input type="text" name="company_phone" value="{{ old('company_phone', $settings['company_phone']) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp (Format 628...)</label>
                        <input type="text" name="company_whatsapp" value="{{ old('company_whatsapp', $settings['company_whatsapp']) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Resmi</label>
                        <input type="email" name="company_email" value="{{ old('company_email', $settings['company_email']) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap Garasi / Kantor</label>
                    <textarea name="company_address" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">{{ old('company_address', $settings['company_address']) }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-indigo-600"></i> Rekening Bank Tujuan Transfer
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Bank</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $settings['bank_name']) }}" placeholder="BCA / Mandiri" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Rekening</label>
                        <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $settings['bank_account_number']) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atas Nama Pemilik (Holder)</label>
                        <input type="text" name="bank_account_holder" value="{{ old('bank_account_holder', $settings['bank_account_holder']) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-scale-balanced text-amber-600"></i> Syarat & Ketentuan Sewa (Dicetak di Kontrak)
                </h3>
                <textarea name="rental_terms" rows="5" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs leading-relaxed focus:ring-2 focus:ring-blue-600 focus:outline-none">{{ old('rental_terms', $settings['rental_terms']) }}</textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-md shadow-blue-600/30 transition">
                    Simpan Semua Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

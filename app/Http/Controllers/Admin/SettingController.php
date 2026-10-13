<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'company_name' => Setting::get('company_name', 'PKD Rental Mobil'),
            'company_tagline' => Setting::get('company_tagline', 'Solusi Sewa Mobil Terpercaya'),
            'company_phone' => Setting::get('company_phone', '0812-3456-7890'),
            'company_whatsapp' => Setting::get('company_whatsapp', '6281234567890'),
            'company_email' => Setting::get('company_email', 'admin@rentalmobil.pkd'),
            'company_address' => Setting::get('company_address', 'Bandung, Jawa Barat'),
            'bank_name' => Setting::get('bank_name', 'BCA'),
            'bank_account_number' => Setting::get('bank_account_number', '8730129841'),
            'bank_account_holder' => Setting::get('bank_account_holder', 'PKD Rental Mobil'),
            'rental_terms' => Setting::get('rental_terms', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'company_name',
            'company_tagline',
            'company_phone',
            'company_whatsapp',
            'company_email',
            'company_address',
            'bank_name',
            'bank_account_number',
            'bank_account_holder',
            'rental_terms',
        ];

        foreach ($fields as $field) {
            Setting::set($field, $request->input($field, ''));
        }

        return back()->with('success', 'Pengaturan rental mobil berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('sim_number', 'like', "%{$search}%");
            });
        }

        $drivers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'sim_number' => ['required', 'string', 'max:50', 'unique:drivers,sim_number'],
            'daily_rate' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:tersedia,bertugas,libur'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
            'notes' => ['nullable', 'string'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('drivers', 'public');
        }

        Driver::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'sim_number' => $validated['sim_number'],
            'daily_rate' => $validated['daily_rate'],
            'status' => $validated['status'],
            'photo' => $photoPath,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Data sopir berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'sim_number' => ['required', 'string', 'max:50', 'unique:drivers,sim_number,' . $driver->id],
            'daily_rate' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:tersedia,bertugas,libur'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:3072'],
            'notes' => ['nullable', 'string'],
        ]);

        $photoPath = $driver->photo;
        if ($request->hasFile('photo')) {
            if ($driver->photo && !str_starts_with($driver->photo, 'http') && Storage::disk('public')->exists($driver->photo)) {
                Storage::disk('public')->delete($driver->photo);
            }
            $photoPath = $request->file('photo')->store('drivers', 'public');
        }

        $driver->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'sim_number' => $validated['sim_number'],
            'daily_rate' => $validated['daily_rate'],
            'status' => $validated['status'],
            'photo' => $photoPath,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Data sopir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        if ($driver->status === 'bertugas') {
            return back()->with('error', 'Sopir sedang bertugas, tidak dapat dihapus.');
        }

        $driver->delete();
        return redirect()->route('admin.drivers.index')->with('success', 'Data sopir berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $categories = CarCategory::all();
        $query = Car::with('category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('car_category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $cars = $query->latest()->paginate(10)->withQueryString();

        return view('admin.cars.index', compact('cars', 'categories'));
    }

    public function create()
    {
        $categories = CarCategory::all();
        return view('admin.cars.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_category_id' => ['required', 'exists:car_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:100'],
            'plate_number' => ['required', 'string', 'max:50', 'unique:cars,plate_number'],
            'year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'color' => ['nullable', 'string', 'max:50'],
            'transmission' => ['required', 'in:Manual,Automatic'],
            'fuel_type' => ['required', 'in:Bensin,Diesel,Hybrid,Listrik'],
            'seating_capacity' => ['required', 'integer', 'min:2', 'max:50'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'penalty_per_hour' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'image_url' => ['nullable', 'url'],
            'features' => ['nullable', 'string'],
            'status' => ['required', 'in:tersedia,disewa,perawatan,nonaktif'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama unit mobil wajib diisi.',
            'plate_number.required' => 'Nomor plat polisi wajib diisi.',
            'plate_number.unique' => 'Nomor plat sudah terdaftar.',
            'price_per_day.required' => 'Tarif sewa per hari wajib diisi.',
        ]);

        $imagePath = $request->input('image_url');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
        }

        Car::create([
            'car_category_id' => $validated['car_category_id'],
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'plate_number' => strtoupper(trim($validated['plate_number'])),
            'year' => $validated['year'],
            'color' => $validated['color'] ?? null,
            'transmission' => $validated['transmission'],
            'fuel_type' => $validated['fuel_type'],
            'seating_capacity' => $validated['seating_capacity'],
            'price_per_day' => $validated['price_per_day'],
            'penalty_per_hour' => $validated['penalty_per_hour'],
            'image' => $imagePath,
            'features' => $validated['features'] ?? null,
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil baru berhasil ditambahkan ke armada!');
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $categories = CarCategory::all();
        return view('admin.cars.edit', compact('car', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'car_category_id' => ['required', 'exists:car_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:100'],
            'plate_number' => ['required', 'string', 'max:50', 'unique:cars,plate_number,' . $car->id],
            'year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'color' => ['nullable', 'string', 'max:50'],
            'transmission' => ['required', 'in:Manual,Automatic'],
            'fuel_type' => ['required', 'in:Bensin,Diesel,Hybrid,Listrik'],
            'seating_capacity' => ['required', 'integer', 'min:2', 'max:50'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'penalty_per_hour' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'image_url' => ['nullable', 'url'],
            'features' => ['nullable', 'string'],
            'status' => ['required', 'in:tersedia,disewa,perawatan,nonaktif'],
            'description' => ['nullable', 'string'],
        ]);

        $imagePath = $car->image;
        if ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }
        if ($request->hasFile('image')) {
            if ($car->image && !str_starts_with($car->image, 'http') && Storage::disk('public')->exists($car->image)) {
                Storage::disk('public')->delete($car->image);
            }
            $imagePath = $request->file('image')->store('cars', 'public');
        }

        $car->update([
            'car_category_id' => $validated['car_category_id'],
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'plate_number' => strtoupper(trim($validated['plate_number'])),
            'year' => $validated['year'],
            'color' => $validated['color'] ?? null,
            'transmission' => $validated['transmission'],
            'fuel_type' => $validated['fuel_type'],
            'seating_capacity' => $validated['seating_capacity'],
            'price_per_day' => $validated['price_per_day'],
            'penalty_per_hour' => $validated['penalty_per_hour'],
            'image' => $imagePath,
            'features' => $validated['features'] ?? null,
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil ' . $car->name . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        if ($car->rentals()->whereIn('status', ['menunggu_konfirmasi', 'dikonfirmasi', 'sedang_berjalan'])->exists()) {
            return back()->with('error', 'Mobil tidak dapat dihapus karena masih terkait dengan transaksi sewa yang sedang aktif.');
        }

        if ($car->image && !str_starts_with($car->image, 'http') && Storage::disk('public')->exists($car->image)) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil dihapus.');
    }
}

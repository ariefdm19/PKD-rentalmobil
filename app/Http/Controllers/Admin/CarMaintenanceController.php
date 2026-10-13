<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarMaintenance;
use Illuminate\Http\Request;

class CarMaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::all();
        $query = CarMaintenance::with('car');

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        $maintenances = $query->latest('maintenance_date')->paginate(10)->withQueryString();
        $totalCost = CarMaintenance::sum('cost');

        return view('admin.maintenances.index', compact('maintenances', 'cars', 'totalCost'));
    }

    public function create()
    {
        $cars = Car::all();
        return view('admin.maintenances.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => ['required', 'exists:cars,id'],
            'service_type' => ['required', 'string', 'max:255'],
            'maintenance_date' => ['required', 'date'],
            'cost' => ['required', 'numeric', 'min:0'],
            'workshop_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'receipt_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,pdf', 'max:4096'],
            'set_car_status' => ['nullable', 'in:perawatan,tersedia'],
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt_file')) {
            $receiptPath = $request->file('receipt_file')->store('maintenances', 'public');
        }

        CarMaintenance::create([
            'car_id' => $validated['car_id'],
            'service_type' => $validated['service_type'],
            'maintenance_date' => $validated['maintenance_date'],
            'cost' => $validated['cost'],
            'workshop_name' => $validated['workshop_name'] ?? null,
            'description' => $validated['description'] ?? null,
            'receipt_file' => $receiptPath,
        ]);

        if (!empty($validated['set_car_status'])) {
            Car::where('id', $validated['car_id'])->update(['status' => $validated['set_car_status']]);
        }

        return redirect()->route('admin.maintenances.index')->with('success', 'Catatan perawatan kendaraan berhasil disimpan!');
    }

    public function destroy($id)
    {
        $maintenance = CarMaintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('admin.maintenances.index')->with('success', 'Catatan perawatan berhasil dihapus.');
    }
}

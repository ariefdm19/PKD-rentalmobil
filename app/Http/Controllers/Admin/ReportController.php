<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarMaintenance;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\RentalReturn;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Pendapatan dari pembayaran sewa
        $payments = Payment::with(['rental.car', 'rental.user'])
            ->where('status', 'diterima')
            ->whereBetween('paid_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $totalRentalIncome = $payments->sum('amount');

        // Pendapatan dari denda pengembalian
        $returns = RentalReturn::with(['rental.car', 'rental.user'])
            ->whereBetween('actual_return_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $totalPenalties = $returns->sum('total_penalty');

        // Pengeluaran perawatan mobil
        $maintenances = CarMaintenance::with('car')
            ->whereBetween('maintenance_date', [$startDate, $endDate])
            ->get();

        $totalMaintenanceCost = $maintenances->sum('cost');

        $grossRevenue = $totalRentalIncome + $totalPenalties;
        $netProfit = $grossRevenue - $totalMaintenanceCost;

        // Mobil paling laris
        $popularCars = Rental::selectRaw('car_id, count(*) as total_rentals, sum(total_amount) as total_earnings')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('car_id')
            ->orderByDesc('total_rentals')
            ->with('car')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'payments',
            'totalRentalIncome',
            'returns',
            'totalPenalties',
            'maintenances',
            'totalMaintenanceCost',
            'grossRevenue',
            'netProfit',
            'popularCars'
        ));
    }

    public function print(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $payments = Payment::with(['rental.car', 'rental.user'])
            ->where('status', 'diterima')
            ->whereBetween('paid_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $returns = RentalReturn::with(['rental.car', 'rental.user'])
            ->whereBetween('actual_return_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $maintenances = CarMaintenance::with('car')
            ->whereBetween('maintenance_date', [$startDate, $endDate])
            ->get();

        $totalRentalIncome = $payments->sum('amount');
        $totalPenalties = $returns->sum('total_penalty');
        $totalMaintenanceCost = $maintenances->sum('cost');
        $grossRevenue = $totalRentalIncome + $totalPenalties;
        $netProfit = $grossRevenue - $totalMaintenanceCost;

        $companyName = Setting::get('company_name', 'PKD Rental Mobil');

        return view('admin.reports.print', compact(
            'startDate',
            'endDate',
            'payments',
            'returns',
            'maintenances',
            'totalRentalIncome',
            'totalPenalties',
            'totalMaintenanceCost',
            'grossRevenue',
            'netProfit',
            'companyName'
        ));
    }
}

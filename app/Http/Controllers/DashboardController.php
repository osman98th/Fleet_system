<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\FuelRecord;
use App\Models\Cost;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary Cards
        $totalVehicles = Vehicle::count();
        $totalDrivers = Driver::count();
        $totalAssignments = 0; // Update if Assignment model exists
        $totalFuelRecords = FuelRecord::count();
        $totalMonthlyCost = Cost::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        // Recent fuels
        $recentFuels = FuelRecord::with(['vehicle', 'driver'])->latest()->take(10)->get();

        // Fuel chart (Last 7 days)
        $fuelData = FuelRecord::selectRaw('DATE(date) as date, SUM(cost) as total_cost')
            ->whereDate('date', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $fuelChartLabels = $fuelData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray();
        $fuelChartData = $fuelData->pluck('total_cost')->toArray();

        // Cost chart (Last 7 days)
        $costData = Cost::selectRaw('DATE(date) as date, SUM(amount) as total_cost')
            ->whereDate('date', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $costChartLabels = $costData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray();
        $costChartData = $costData->pluck('total_cost')->toArray();

        // Vehicles and Drivers for filter dropdown
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        return view('dashboard.index', compact(
            'totalVehicles',
            'totalDrivers',
            'totalAssignments',
            'totalFuelRecords',
            'totalMonthlyCost',
            'recentFuels',
            'fuelChartLabels',
            'fuelChartData',
            'costChartLabels',
            'costChartData',
            'vehicles',
            'drivers'
        ));
    }

    // AJAX filter for Fuel
    public function filterFuel(Request $request)
    {
        $query = FuelRecord::with(['vehicle', 'driver']);

        if ($request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->driver_id) {
            $query->where('driver_id', $request->driver_id);
        }

        $records = $query->whereDate('date', '>=', now()->subDays(6))
            ->orderBy('date')
            ->get();

        $result = $records->map(function ($r) {
            return [
                'vehicle' => $r->vehicle->name ?? 'N/A',
                'driver' => $r->driver->name ?? 'Unassigned',
                'cost' => number_format($r->cost, 2),
                'date' => $r->date->format('d M')
            ];
        });

        return response()->json($result);
    }

    // AJAX filter for Cost
    public function filterCost(Request $request)
    {
        $query = Cost::query();

        if ($request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->driver_id) {
            $query->where('driver_id', $request->driver_id);
        }

        $records = $query->whereDate('date', '>=', now()->subDays(6))
            ->orderBy('date')
            ->get();

        $result = $records->map(function ($r) {
            return [
                'amount' => number_format($r->amount, 2),
                'date' => $r->date->format('d M')
            ];
        });

        return response()->json($result);
    }
}

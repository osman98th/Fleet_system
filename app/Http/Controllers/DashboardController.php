<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\FuelRecord;

class DashboardController extends Controller
{
    public function index()
    {
        // === Summary ===
        $totalVehicles = Vehicle::count();
        $totalDrivers  = Driver::count();
        $totalFuelCost = FuelRecord::sum('cost');
        $avgFuelCost   = FuelRecord::avg('cost');

        // === Fuel Cost Chart (Last 7 days) ===
        $chartData = FuelRecord::selectRaw('DATE(date) as date, SUM(cost) as total_cost')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(7)
            ->get()
            ->reverse();

        // === Recent Activity (Last 5 Records) ===
        // changed: fallback for missing `vehicle_name` column
        $recentVehicles = Vehicle::select('id', 'name as vehicle_name', 'created_at')
            ->latest()
            ->take(5)
            ->get();

        $recentDrivers  = Driver::select('id', 'name as driver_name', 'created_at')
            ->latest()
            ->take(5)
            ->get();

        $recentFuel     = FuelRecord::latest()->take(5)->get(['date', 'liters', 'cost', 'created_at']);

        return view('dashboard.index', compact(
            'totalVehicles',
            'totalDrivers',
            'totalFuelCost',
            'avgFuelCost',
            'chartData',
            'recentVehicles',
            'recentDrivers',
            'recentFuel'
        ));
    }
}

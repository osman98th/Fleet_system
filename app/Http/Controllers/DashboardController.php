<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\FuelRecord;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVehicles = Vehicle::count();
        $totalDrivers  = Driver::count();
        $totalFuelCost = FuelRecord::sum('cost');
        $avgFuelCost   = FuelRecord::avg('cost');

        // Chart Data (Last 7 Days)
        $chartData = FuelRecord::select(
            DB::raw('DATE(date) as date'),
            DB::raw('SUM(cost) as total_cost')
        )
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(7)
        ->get()
        ->reverse();

        // Recent Activity (Last 5 Records)
        $recentVehicles = Vehicle::latest()->take(5)->get(['vehicle_name', 'created_at']);
        $recentDrivers  = Driver::latest()->take(5)->get(['driver_name', 'created_at']);
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

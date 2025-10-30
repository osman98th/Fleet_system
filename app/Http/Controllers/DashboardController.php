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
    $totalVehicles = Vehicle::count();
    $totalDrivers = Driver::count();
    $totalFuelCost = FuelRecord::sum('cost');
    $avgFuelCost = FuelRecord::avg('cost');

    $recentVehicles = Vehicle::latest()->take(5)->get();
    $recentDrivers = Driver::latest()->take(5)->get();
    $recentFuel = FuelRecord::latest()->take(5)->get();

    $fuelChart = FuelRecord::selectRaw('DATE(date) as date, SUM(cost) as total_cost')
        ->where('date', '>=', now()->subDays(6))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    $fleetFeatures = [
        'Dynamic Admin Panel',
        'User Management System',
        'GPS Tracking System',
        'Fuel Management',
        'Financial Management System',
        'Human Resource Management System',
        'Inventory Management System',
        'Service Management',
        'Vehicle Assignment System',
        'Reporting System',
        'Real-Time Notification System',
    ];

    return view('dashboard.index', compact(
        'totalVehicles', 
        'totalDrivers', 
        'totalFuelCost', 
        'avgFuelCost', 
        'recentVehicles', 
        'recentDrivers', 
        'recentFuel', 
        'fuelChart',
        'fleetFeatures'
    ));
}


}

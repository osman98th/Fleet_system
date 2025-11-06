<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Assignment;
use App\Models\Fuel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVehicles    = Vehicle::count();
        $totalDrivers     = Driver::count();
        $totalAssignments = Assignment::count();
        $totalFuelRecords = Fuel::count();

        $recentVehicles = Vehicle::latest()->take(5)->get();
        $recentFuels    = Fuel::with(['vehicle','driver'])->latest()->take(5)->get();

        $fuelChartData = Fuel::selectRaw('DATE(date) as fuel_date, SUM(quantity) as qty')
            ->whereDate('date', '>=', now()->subDays(7))
            ->groupBy('fuel_date')
            ->orderBy('fuel_date','ASC')
            ->get();

        $fuelChartLabels = $fuelChartData->pluck('fuel_date')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $fuelChartData   = $fuelChartData->pluck('qty');

        $vehicles = Vehicle::orderBy('name')->get();
        $drivers  = Driver::orderBy('name')->get();

        return view('dashboard.index', compact(
            'totalVehicles','totalDrivers','totalAssignments','totalFuelRecords',
            'recentVehicles','recentFuels',
            'fuelChartLabels','fuelChartData',
            'vehicles','drivers'
        ));
    }

    public function filterFuel(Request $request)
    {
        $fuels = Fuel::with(['vehicle','driver'])
            ->when($request->vehicle_id, fn($q)=>$q->where('vehicle_id',$request->vehicle_id))
            ->when($request->driver_id, fn($q)=>$q->where('driver_id',$request->driver_id))
            ->orderBy('date','asc')
            ->get();

        $data = $fuels->map(fn($fuel)=>[
            'vehicle_name'=>$fuel->vehicle->name ?? 'N/A',
            'driver_name'=>$fuel->driver->name ?? 'Unassigned',
            'quantity'=>$fuel->quantity,
            'price'=>number_format($fuel->price,2),
            'date'=>Carbon::parse($fuel->date)->format('d M Y'),
        ]);

        return response()->json($data);
    }
}

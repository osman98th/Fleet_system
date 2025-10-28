<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelRecord;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function fuelReport()
    {
        // প্রতিটি গাড়ির মোট ফুয়েল খরচ
        $reportData = FuelRecord::select(
            'vehicle_id',
            DB::raw('SUM(liters) as total_liters'),
            DB::raw('SUM(cost) as total_cost'),
            DB::raw('ROUND(SUM(cost)/SUM(liters), 2) as avg_cost_per_liter')
        )
        ->groupBy('vehicle_id')
        ->with('vehicle')
        ->get();

        // তারিখভিত্তিক সারসংক্ষেপ চার্টের জন্য
        $dailyData = FuelRecord::select(
            DB::raw('DATE(date) as date'),
            DB::raw('SUM(cost) as daily_cost')
        )
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        return view('reports.fuel', compact('reportData', 'dailyData'));
    }
}

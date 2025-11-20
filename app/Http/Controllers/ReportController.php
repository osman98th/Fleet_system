<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelRecord;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /*-----------------------------------------
     | FUEL REPORT (HTML VIEW)
     *----------------------------------------*/
    public function fuelReport(Request $request)
    {
        $vehicles = Vehicle::orderBy('name')->get();
        $query = FuelRecord::with(['vehicle', 'driver'])->orderBy('date', 'desc');

        // Vehicle filter
        if ($request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        // Month filter
        if ($request->month) {
            $date = Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        }

        // From and To date filter
        if ($request->from_date) $query->whereDate('date', '>=', $request->from_date);
        if ($request->to_date) $query->whereDate('date', '<=', $request->to_date);

        $fuelRecords = $query->get();

        // Daily Fuel Cost chart
        $dailyData = FuelRecord::select(DB::raw('DATE(date) as date'), DB::raw('SUM(cost) as daily_cost'))
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date', 'asc')
            ->get();

        $labels = $dailyData->pluck('date')->map(fn($d) => date('d M', strtotime($d)))->toArray();
        $values = $dailyData->pluck('daily_cost')->toArray();

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Daily Fuel Cost',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'data' => $values
                ]]
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales' => ['y' => ['beginAtZero' => true]]
            ]
        ];

        $chartImage = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));

        return view('reports.fuel', compact('fuelRecords', 'vehicles', 'chartImage'));
    }

    /*-----------------------------------------
     | FUEL REPORT PDF
     *----------------------------------------*/
    public function fuelReportPdf(Request $request)
    {
        $query = FuelRecord::with(['vehicle', 'driver'])->orderBy('date', 'desc');

        if ($request->vehicle_id) $query->where('vehicle_id', $request->vehicle_id);
        if ($request->month) {
            $date = Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)
                ->whereYear('date', $date->year);
        }
        if ($request->from_date) $query->whereDate('date', '>=', $request->from_date);
        if ($request->to_date) $query->whereDate('date', '<=', $request->to_date);

        $fuelRecords = $query->get();

        // Daily Fuel Cost chart for PDF
        $dailyData = FuelRecord::select(DB::raw('DATE(date) as date'), DB::raw('SUM(cost) as daily_cost'))
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date', 'asc')
            ->get();

        $labels = $dailyData->pluck('date')->map(fn($d) => date('d M', strtotime($d)))->toArray();
        $values = $dailyData->pluck('daily_cost')->toArray();

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Daily Fuel Cost',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'data' => $values
                ]]
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales' => ['y' => ['beginAtZero' => true]]
            ]
        ];

        $chartImage = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));

        return Pdf::loadView('reports.fuel-pdf', compact('fuelRecords', 'chartImage'))
            ->setPaper('A4', 'landscape')
            ->stream('fuel-report.pdf');
    }
}

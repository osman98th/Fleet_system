<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Fuel Report Page
     */
    public function fuelReport(Request $request)
    {
        $reportData = FuelRecord::select(
            'vehicle_id',
            DB::raw('SUM(liters) as total_liters'),
            DB::raw('SUM(cost) as total_cost'),
            DB::raw('ROUND(SUM(cost)/SUM(liters),2) as avg_cost_per_liter'),
            DB::raw('COUNT(DISTINCT date) as total_days'),
            DB::raw('SUM(IFNULL(distance,0)) as total_km')
        )
            ->with('vehicle')
            ->groupBy('vehicle_id')
            ->get()
            ->map(function ($r) {
                $r->vehicle_name = $r->vehicle->name ?? '-';
                $r->cost_per_day = $r->total_days ? round($r->total_cost / $r->total_days, 2) : 0;
                $r->cost_per_km  = $r->total_km ? round($r->total_cost / $r->total_km, 2) : 0;
                return $r;
            });

        $dailyData = FuelRecord::select(
            DB::raw('DATE(date) as date'),
            DB::raw('SUM(cost) as daily_cost')
        )
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

        return view('reports.fuel', compact('reportData', 'dailyData', 'chartImage'));
    }

    /**
     * Fuel PDF Download
     */
    public function fuelReportPdf(Request $request)
    {
        $reportData = FuelRecord::select(
            'vehicle_id',
            DB::raw('SUM(liters) as total_liters'),
            DB::raw('SUM(cost) as total_cost'),
            DB::raw('ROUND(SUM(cost)/SUM(liters),2) as avg_cost_per_liter'),
            DB::raw('COUNT(DISTINCT date) as total_days'),
            DB::raw('SUM(IFNULL(distance,0)) as total_km')
        )
            ->with('vehicle')
            ->groupBy('vehicle_id')
            ->get()
            ->map(function ($r) {
                $r->vehicle_name = $r->vehicle->name ?? '-';
                $r->cost_per_day = $r->total_days ? round($r->total_cost / $r->total_days, 2) : 0;
                $r->cost_per_km  = $r->total_km ? round($r->total_cost / $r->total_km, 2) : 0;
                return $r;
            });

        $dailyData = FuelRecord::select(
            DB::raw('DATE(date) as date'),
            DB::raw('SUM(cost) as daily_cost')
        )
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
                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
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

        $pdf = Pdf::loadView('reports.fuel-pdf', compact('reportData', 'dailyData', 'chartImage'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('fuel-report.pdf');
    }

    /**
     * Total Expense Page
     */
    public function totalExpense()
    {
        // সব fuel records load করা এবং vehicle relation সহ
        $fuelRecords  = FuelRecord::with('vehicle')->orderBy('date', 'desc')->get();

        // total expense হিসাব
        $totalExpense = $fuelRecords->sum('cost');

        return view('reports.total_expense', compact('fuelRecords', 'totalExpense'));
    }
}

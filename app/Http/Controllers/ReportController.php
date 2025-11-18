<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Fuel Report Page
     */
    public function fuelReport()
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
    public function fuelReportPdf()
    {
        $reportData = FuelRecord::with('vehicle')->get();
        $pdf = Pdf::loadView('reports.fuel-pdf', compact('reportData'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('fuel-report.pdf');
    }

    /**
     * Total Expense Page
     */
    public function totalExpense(Request $request)
    {
        $records = $this->prepareExpenseRecords($request);
        $totalExpense = $records->sum(function ($r) {
            return ($r->fuel_cost ?? 0) + ($r->maintenance_cost ?? 0) + ($r->food_cost ?? 0) +
                ($r->stipend_cost ?? 0) + ($r->parking_cost ?? 0) + ($r->toll_cost ?? 0);
        });

        return view('reports.total_expense', compact('records', 'totalExpense'));
    }

    /**
     * Total Expense PDF
     */
    public function totalExpensePdf(Request $request)
    {
        $records = $this->prepareExpenseRecords($request);
        $totalExpense = $records->sum(function ($r) {
            return ($r->fuel_cost ?? 0) + ($r->maintenance_cost ?? 0) + ($r->food_cost ?? 0) +
                ($r->stipend_cost ?? 0) + ($r->parking_cost ?? 0) + ($r->toll_cost ?? 0);
        });

        $pdf = Pdf::loadView('reports.total_expense_pdf', compact('records', 'totalExpense'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('total-expense-report.pdf');
    }

    /**
     * Prepare all expense records with optional filters
     */
    private function prepareExpenseRecords(Request $request)
    {
        $records = collect();
        $month = $request->month;
        $vehicleId = $request->vehicle_id;

        $filter = function ($q) use ($month, $vehicleId) {
            if ($month) {
                $date = Carbon::parse($month);
                $q->whereMonth('date', $date->month)
                    ->whereYear('date', $date->year);
            }
            if ($vehicleId) {
                $q->where('vehicle_id', $vehicleId);
            }
        };

        // Fuel
        if (Schema::hasTable('fuel_records')) {
            $fuelRecords = \App\Models\FuelRecord::with('vehicle')->when($month, $filter)->orderBy('date', 'desc')->get()->map(function ($r) {
                $r->type = 'Fuel';
                $r->fuel_cost = $r->cost;
                $r->maintenance_cost = 0;
                $r->food_cost = 0;
                $r->stipend_cost = 0;
                $r->parking_cost = 0;
                $r->toll_cost = 0;
                return $r;
            });
            $records = $records->merge($fuelRecords);
        }

        // Maintenance
        if (Schema::hasTable('maintenances')) {
            $maintenance = DB::table('maintenances')->when($month, $filter)->get()->map(function ($r) {
                $r->type = 'Maintenance';
                $r->fuel_cost = 0;
                $r->maintenance_cost = $r->cost;
                $r->food_cost = 0;
                $r->stipend_cost = 0;
                $r->parking_cost = 0;
                $r->toll_cost = 0;
                $r->vehicle = null;
                return $r;
            });
            $records = $records->merge($maintenance);
        }

        // Food
        if (Schema::hasTable('foods')) {
            $food = DB::table('foods')->when($month, $filter)->get()->map(function ($r) {
                $r->type = 'Food';
                $r->fuel_cost = 0;
                $r->maintenance_cost = 0;
                $r->food_cost = $r->cost;
                $r->stipend_cost = 0;
                $r->parking_cost = 0;
                $r->toll_cost = 0;
                $r->vehicle = null;
                return $r;
            });
            $records = $records->merge($food);
        }

        // Stipend
        if (Schema::hasTable('stipends')) {
            $stipend = DB::table('stipends')->when($month, $filter)->get()->map(function ($r) {
                $r->type = 'Stipend';
                $r->fuel_cost = 0;
                $r->maintenance_cost = 0;
                $r->food_cost = 0;
                $r->stipend_cost = $r->amount;
                $r->parking_cost = 0;
                $r->toll_cost = 0;
                $r->vehicle = null;
                return $r;
            });
            $records = $records->merge($stipend);
        }

        // Parking
        if (Schema::hasTable('parkings')) {
            $parking = DB::table('parkings')->when($month, $filter)->get()->map(function ($r) {
                $r->type = 'Parking';
                $r->fuel_cost = 0;
                $r->maintenance_cost = 0;
                $r->food_cost = 0;
                $r->stipend_cost = 0;
                $r->parking_cost = $r->cost;
                $r->toll_cost = 0;
                $r->vehicle = null;
                return $r;
            });
            $records = $records->merge($parking);
        }

        // Toll
        if (Schema::hasTable('tolls')) {
            $toll = DB::table('tolls')->when($month, $filter)->get()->map(function ($r) {
                $r->type = 'Toll';
                $r->fuel_cost = 0;
                $r->maintenance_cost = 0;
                $r->food_cost = 0;
                $r->stipend_cost = 0;
                $r->parking_cost = 0;
                $r->toll_cost = $r->cost;
                $r->vehicle = null;
                return $r;
            });
            $records = $records->merge($toll);
        }

        return $records->sortByDesc('date');
    }
}

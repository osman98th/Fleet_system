<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Vehicle;
use App\Models\FuelRecord;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CostController extends Controller
{
    // Index - show paginated costs with monthly total
    public function index()
    {
        $costs = Cost::with('vehicle')->latest()->paginate(10);

        $totalMonthlyCost = Cost::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        return view('costs.index', compact('costs', 'totalMonthlyCost'));
    }

    // Create - show form to add cost
    public function create()
    {
        $vehicles = Vehicle::orderBy('name')->get();
        return view('costs.create', compact('vehicles'));
    }

    // Store - save new cost
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        Cost::create($data);

        return redirect()->route('costs.index')->with('success', 'Cost added successfully.');
    }

    // Edit - show form to edit cost
    public function edit(Cost $cost)
    {
        $vehicles = Vehicle::orderBy('name')->get();
        return view('costs.edit', compact('cost', 'vehicles'));
    }

    // Update - update existing cost
    public function update(Request $request, Cost $cost)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $cost->update($data);

        return redirect()->route('costs.index')->with('success', 'Cost updated successfully.');
    }

    // Destroy - delete cost
    public function destroy(Cost $cost)
    {
        $cost->delete();
        return redirect()->route('costs.index')->with('success', 'Cost deleted successfully.');
    }

    // PDF Report - all costs
    public function pdfReport()
    {
        $costs = Cost::with('vehicle')->latest()->get();
        $pdf = Pdf::loadView('costs.pdf', compact('costs'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('cost-report.pdf');
    }

    // Vehicle-wise Profit Dashboard (web view)
    public function vehicleProfitDashboard(Request $request)
    {
        $vehicles = Vehicle::orderBy('name')->get();
        $data = [];

        foreach ($vehicles as $v) {
            $fuelQuery = FuelRecord::where('vehicle_id', $v->id);
            $costQuery = Cost::where('vehicle_id', $v->id);
            $bookingQuery = Booking::where('vehicle_id', $v->id);

            // Filter by month if provided
            if ($request->month) {
                $date = Carbon::parse($request->month);
                $fuelQuery->whereMonth('date', $date->month)->whereYear('date', $date->year);
                $costQuery->whereMonth('date', $date->month)->whereYear('date', $date->year);
                $bookingQuery->whereMonth('date', $date->month)->whereYear('date', $date->year);
            }

            $fuel = $fuelQuery->sum('cost');
            $otherCosts = $costQuery->sum('amount');
            $income = $bookingQuery->sum('fare');
            $profit = $income - ($fuel + $otherCosts);

            $data[] = [
                'vehicle' => $v,
                'fuel' => $fuel,
                'otherCosts' => $otherCosts,
                'income' => $income,
                'profit' => $profit,
            ];
        }

        return view('costs.vehicle-profit-dashboard', compact('data'));
    }

    // Vehicle-wise Profit PDF
    public function vehicleProfitPdf(Request $request)
    {
        $vehicles = Vehicle::orderBy('name')->get();
        $data = [];

        foreach ($vehicles as $v) {
            $fuelQuery = FuelRecord::where('vehicle_id', $v->id);
            $costQuery = Cost::where('vehicle_id', $v->id);
            $bookingQuery = Booking::where('vehicle_id', $v->id);

            // Filter by month if provided
            if ($request->month) {
                $date = Carbon::parse($request->month);
                $fuelQuery->whereMonth('date', $date->month)->whereYear('date', $date->year);
                $costQuery->whereMonth('date', $date->month)->whereYear('date', $date->year);
                $bookingQuery->whereMonth('date', $date->month)->whereYear('date', $date->year);
            }

            $fuel = $fuelQuery->sum('cost');
            $otherCosts = $costQuery->sum('amount');
            $income = $bookingQuery->sum('fare');
            $profit = $income - ($fuel + $otherCosts);

            $data[] = [
                'vehicle' => $v,
                'fuel' => $fuel,
                'otherCosts' => $otherCosts,
                'income' => $income,
                'profit' => $profit,
            ];
        }

        $pdf = Pdf::loadView('costs.vehicle-profit-pdf', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('vehicle-profit-report.pdf');
    }
}

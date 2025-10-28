<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelRecord;
use App\Models\Vehicle;

class FuelRecordController extends Controller
{
    public function index()
    {
        $fuels = FuelRecord::with('vehicle')->get();
        return view('fuels.index', compact('fuels'));
    }

    public function create()
    {
        $vehicles = Vehicle::all(); // বিদ্যমান vehicle গুলো
        return view('fuels.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id', // vehicle must exist
            'date' => 'required|date',
            'liters' => 'required|numeric',
            'cost' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);

        FuelRecord::create($request->all());

        return redirect()->route('fuels.index')->with('success', 'Fuel record added successfully!');
    }

    public function edit(FuelRecord $fuel)
    {
        $vehicles = Vehicle::all();
        return view('fuels.edit', compact('fuel', 'vehicles'));
    }

    public function update(Request $request, FuelRecord $fuel)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'date' => 'required|date',
            'liters' => 'required|numeric',
            'cost' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);

        $fuel->update($request->all());

        return redirect()->route('fuels.index')->with('success', 'Fuel record updated successfully!');
    }

    public function destroy(FuelRecord $fuel)
    {
        $fuel->delete();
        return redirect()->route('fuels.index')->with('success', 'Fuel record deleted successfully!');
    }
}

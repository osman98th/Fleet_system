<?php

namespace App\Http\Controllers;

use App\Models\VehicleAssignment;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;

class VehicleAssignmentController extends Controller
{
    public function index()
    {
        $assignments = VehicleAssignment::with(['vehicle', 'driver'])->get();
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('assignments.create', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'assigned_date' => 'required|date',
        ]);

        VehicleAssignment::create($request->all());
        return redirect()->route('assignments.index')->with('success', 'Vehicle assigned successfully!');
    }

    public function destroy(VehicleAssignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Assignment deleted!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['driver', 'vehicle'])->get();
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        return view('assignments.create', compact('drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'status' => 'nullable',
        ]);

        Assignment::create($request->all());
        return redirect()->route('assignments.index')->with('success', 'Assignment added successfully!');
    }

    public function edit(Assignment $assignment)
    {
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        return view('assignments.edit', compact('assignment', 'drivers', 'vehicles'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title' => 'required',
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'status' => 'nullable',
        ]);

        $assignment->update($request->all());
        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully!');
    }

    // public function destroy(Assignment $assignment)
    // {
    //     $assignment->delete();
    //     return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully!');
    // }
}

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
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'assigned_date' => 'required|date',
            'status' => 'required|in:assigned,completed,pending',
        ]);

        Assignment::create($request->only([
            'vehicle_id',
            'driver_id',
            'assigned_date',
            'status',
        ]));

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully!');
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
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'assigned_date' => 'required|date',
            'status' => 'required|in:assigned,completed,pending',
        ]);

        $assignment->update($request->only([
            'vehicle_id',
            'driver_id',
            'assigned_date',
            'status',
        ]));

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully!');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully!');
    }
}

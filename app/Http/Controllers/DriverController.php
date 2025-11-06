<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('vehicle')->get();
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        return view('drivers.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'route' => 'nullable|string|max:255',
            'status' => 'required|in:Available,Inactive',
        ]);

        Driver::create($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver added successfully!');
    }

    public function edit(Driver $driver)
    {
        $vehicles = Vehicle::all();
        return view('drivers.edit', compact('driver', 'vehicles'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'route' => 'nullable|string|max:255',
            'status' => 'required|in:Available,Inactive',
        ]);

        $driver->update($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully!');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully!');
    }
}

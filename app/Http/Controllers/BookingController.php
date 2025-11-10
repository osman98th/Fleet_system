<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['vehicle', 'driver', 'customer'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('bookings.create', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date',
            'car_type' => 'required|in:ac,non_ac',
            'charge_type' => 'required|in:km,days',
            'distance' => 'nullable|numeric|min:0',
            'fare' => 'required|numeric|min:0',
        ]);

        $data['customer_id'] = Auth::id();
        $data['status'] = 'Pending';

        $booking = Booking::create($data);

        return redirect()->route('bookings.invoice', $booking->id)
            ->with('success', 'Booking created successfully!');
    }

    public function edit(Booking $booking)
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        return view('bookings.edit', compact('booking', 'vehicles', 'drivers'));
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date',
            'car_type' => 'required|in:ac,non_ac',
            'charge_type' => 'required|in:km,days',
            'distance' => 'nullable|numeric|min:0',
            'fare' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        $booking->update($data);
        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted.');
    }

    public function invoice($id)
{
    $booking = Booking::with(['customer', 'vehicle', 'driver'])->findOrFail($id);

    // Instantiate DNS1D
    $d = new DNS1D();

    // Generate barcode for the booking ID
    $barcode = $d->getBarcodePNG((string)$booking->id, 'C128', 2, 50);


    return view('bookings.invoice', compact('booking', 'barcode'));
}
}

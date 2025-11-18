<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use PDF; // barryvdh/laravel-dompdf
use Milon\Barcode\DNS1D;
use SimpleSoftwareIO\QrCode\Generator;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['vehicle', 'driver', 'customer'])->latest();

        if ($request->filled('customer')) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', '%' . $request->customer . '%'));
        }

        if ($request->filled('vehicle')) {
            $query->whereHas('vehicle', fn($q) => $q->where('name', 'like', '%' . $request->vehicle . '%'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->get();

        return view('bookings.index', [
            'bookings' => $bookings,
            'filters'  => $request->only(['customer', 'vehicle', 'status'])
        ]);
    }

    /**
     * Show form to create a booking.
     */
    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers  = Driver::all();
        return view('bookings.create', compact('vehicles', 'drivers'));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'driver_id'     => 'required|exists:drivers,id',
            'start_datetime' => 'required|date',
            'end_datetime'  => 'required|date',
            'car_type'      => 'required|in:ac,non_ac',
            'charge_type'   => 'required|in:km,days',
            'distance'      => 'nullable|numeric|min:0',
            'fare'          => 'required|numeric|min:0',
        ]);

        // Get or create customer
        $customer = Customer::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'name'    => Auth::user()->name,
                'email'   => Auth::user()->email ?? ('noemail' . time() . '@example.com'),
                'phone'   => 'N/A',
                'address' => 'N/A',
            ]
        );

        $data['customer_id'] = $customer->id;
        $data['status'] = 'pending';

        $booking = Booking::create($data);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }

    /**
     * Show form to edit a booking.
     */
    public function edit(Booking $booking)
    {
        $vehicles = Vehicle::all();
        $drivers  = Driver::all();
        return view('bookings.edit', compact('booking', 'vehicles', 'drivers'));
    }

    /**
     * Update an existing booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'driver_id'     => 'required|exists:drivers,id',
            'start_datetime' => 'required|date',
            'end_datetime'  => 'required|date',
            'car_type'      => 'required|in:ac,non_ac',
            'charge_type'   => 'required|in:km,days',
            'distance'      => 'nullable|numeric|min:0',
            'fare'          => 'required|numeric|min:0',
        ]);

        $booking->update($data);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
    }

    /**
     * Delete a booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking deleted successfully!');
    }

    /**
     * Generate invoice view with barcode and QR code.
     */
    public function invoice(Booking $booking)
    {
        $booking->load(['vehicle', 'driver', 'customer']);

        $barcodeGenerator = new DNS1D();
        $barcode = $barcodeGenerator->getBarcodePNG(
            'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'C39'
        );

        $qrGenerator = new Generator();
        $qrCode = base64_encode(
            $qrGenerator->size(120)->generate(route('bookings.invoice', $booking->id))
        );

        return view('bookings.invoice_premium', compact('booking', 'barcode', 'qrCode'));
    }

    /**
     * Download invoice PDF.
     */
    public function downloadPDF(Booking $booking)
    {
        $booking->load(['vehicle', 'driver', 'customer']);

        $barcodeGenerator = new DNS1D();
        $barcode = $barcodeGenerator->getBarcodePNG(
            'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'C39'
        );

        $qrGenerator = new Generator();
        $qrCode = base64_encode(
            $qrGenerator->size(120)->generate(route('bookings.invoice', $booking->id))
        );

        $pdf = PDF::loadView('bookings.invoice_premium', compact('booking', 'barcode', 'qrCode'));
        return $pdf->download('invoice_INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * AJAX: Get fare based on vehicle, car type, charge type, and distance/days.
     */
    public function getFare(Request $request)
    {
        $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'car_type'    => 'required|in:ac,non_ac',
            'charge_type' => 'required|in:km,days',
            'distance'    => 'nullable|numeric|min:0',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $fare = 0;

        if ($request->car_type === 'ac') {
            $fare = ($request->charge_type === 'km') ? $vehicle->ac_price : $vehicle->ac_price_per_day;
        } else {
            $fare = ($request->charge_type === 'km') ? $vehicle->non_ac_price : $vehicle->non_ac_price_per_day;
        }

        if ($request->charge_type === 'days') {
            if ($request->start_date && $request->end_date) {
                $start = strtotime($request->start_date);
                $end   = strtotime($request->end_date);
                $days  = max(1, ceil(($end - $start) / (60 * 60 * 24)));
                $fare *= $days;
            }
        } else {
            $distance = $request->distance ?? 0;
            $fare *= $distance;
        }

        return response()->json(['fare' => number_format($fare, 2)]);
    }
}

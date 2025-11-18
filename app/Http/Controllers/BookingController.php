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
     * Display a listing of bookings with optional filters.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['vehicle', 'driver', 'customer'])->latest();

        // Filter by customer name
        if ($request->filled('customer')) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', '%' . $request->customer . '%'));
        }

        // Filter by vehicle name
        if ($request->filled('vehicle')) {
            $query->whereHas('vehicle', fn($q) => $q->where('name', 'like', '%' . $request->vehicle . '%'));
        }

        // Filter by booking status
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
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers  = Driver::all();

        return view('bookings.create', compact('vehicles', 'drivers'));
    }

    /**
     * Store a newly created booking in storage and generate PDF invoice.
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

        // Update email if empty
        if (empty($customer->email)) {
            $safeEmail = Auth::user()->email ?? ('noemail' . time() . '@example.com');
            if (!Customer::where('email', $safeEmail)->where('id', '!=', $customer->id)->exists()) {
                $customer->email = $safeEmail;
                $customer->save();
            }
        }

        // Save booking
        $data['customer_id'] = $customer->id;
        $data['status']      = 'pending';
        $booking = Booking::create($data);

        // Barcode (DNS1D)
        $barcodeGenerator = new DNS1D();
        $barcode = $barcodeGenerator->getBarcodePNG(
            'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'C39'
        );

        // QR code (SVG, no Imagick needed)
        $qrGenerator = new Generator();
        $qrCode = base64_encode(
            $qrGenerator->size(120)
                ->generate(route('bookings.invoice', $booking->id))
        );

        // Generate PDF
        $pdf = PDF::loadView('bookings.invoice_premium', compact('booking', 'barcode', 'qrCode'));
        return $pdf->stream('invoice_INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Show booking invoice view with barcode and QR code.
     */
    public function invoice($id)
    {
        $booking = Booking::with(['vehicle', 'driver', 'customer'])->findOrFail($id);

        $barcodeGenerator = new DNS1D();
        $barcode = $barcodeGenerator->getBarcodePNG(
            'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'C39'
        );

        $qrGenerator = new Generator();
        $qrCode = base64_encode(
            $qrGenerator->size(120)
                ->generate(route('bookings.invoice', $booking->id))
        );

        return view('bookings.invoice_premium', compact('booking', 'barcode', 'qrCode'));
    }

    /**
     * Delete a booking.
     */
    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return back()->with('success', 'Booking deleted successfully!');
    }
}

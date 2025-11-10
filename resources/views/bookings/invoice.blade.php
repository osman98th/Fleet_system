@extends('layouts.app')
@section('title','Booking Invoice')

@section('content')

<style>
    /* Print-friendly invoice */
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice, #invoice * {
            visibility: visible;
        }
        #invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }

    .invoice-box {
        border: 1px solid #eee;
        padding: 30px;
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
        background-color: #fff;
    }
    .invoice-box h2 {
        font-size: 24px;
        line-height: 24px;
        color: #333;
        margin-bottom: 20px;
    }
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-collapse: collapse;
    }
    .invoice-box table td, .invoice-box table th {
        padding: 8px;
        border: 1px solid #eee;
    }
    .invoice-box table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .invoice-box .total {
        font-weight: bold;
        font-size: 18px;
    }
</style>

<div class="container py-5" id="invoice">
    <div class="invoice-box shadow-sm">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>YourCompany</h2>
                <p>Rental Car Service</p>
            </div>
            <div class="text-end">
                <img src="data:image/png;base64,{{ $barcode }}" alt="Booking Barcode">
                <p class="mb-0"><strong>Invoice #:</strong> INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="mb-0"><strong>Date:</strong> {{ now()->format('d M, Y') }}</p>
            </div>
        </div>

        <!-- Customer & Booking Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Customer Info</h5>
                <p class="mb-1"><strong>Name:</strong> {{ $booking->customer->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $booking->customer->email ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Booking Info</h5>
                <p class="mb-1"><strong>Car:</strong> {{ $booking->vehicle->name }} ({{ $booking->vehicle->license_plate }})</p>
                <p class="mb-1"><strong>Driver:</strong> {{ $booking->driver->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Rent Period:</strong> {{ $booking->rent_start_date }} → {{ $booking->rent_end_date }}</p>
                <p class="mb-1"><strong>Status:</strong> <span class="badge bg-{{ $booking->status==='completed' ? 'success' : ($booking->status==='pending' ? 'warning' : 'secondary') }}">{{ ucfirst($booking->status) }}</span></p>
            </div>
        </div>

        <!-- Booking Details Table -->
        <h5 class="mb-3">Booking Details</h5>
        <table>
            <tbody>
                <tr>
                    <th>Car Type</th>
                    <td>{{ ucfirst($booking->car_type) }}</td>
                </tr>
                <tr>
                    <th>Charge Type</th>
                    <td>{{ ucfirst($booking->charge_type) }}</td>
                </tr>
                @if($booking->charge_type==='km')
                <tr>
                    <th>Distance/KM</th>
                    <td>{{ $booking->distance }} km</td>
                </tr>
                @endif
                <tr>
                    <th class="total">Fare</th>
                    <td class="total text-success">${{ number_format($booking->fare,2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="text-center mt-4">
            <p class="mb-0">Thank you for choosing our services!</p>
            <small>© {{ now()->year }} YourCompany. All rights reserved.</small>
        </div>

        <!-- Print & Back Buttons -->
        <div class="mt-4 d-flex gap-2 no-print">
            <button onclick="window.print()" class="btn btn-success"><i class="bi bi-printer"></i> Print Invoice</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left-circle"></i> Back to Bookings</a>
        </div>
    </div>
</div>

@endsection

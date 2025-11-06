@extends('layouts.app')
@section('title','Booking Invoice')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">🧾 Booking Invoice</h3>

    <div class="card p-4 shadow-sm">
        <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
        <p><strong>Customer:</strong> {{ $booking->customer->name ?? 'N/A' }}</p>
        <p><strong>Car:</strong> {{ $booking->vehicle->name }} ({{ $booking->vehicle->license_plate }})</p>
        <p><strong>Driver:</strong> {{ $booking->driver->name ?? 'N/A' }}</p>
        <p><strong>Rent Start:</strong> {{ $booking->rent_start_date }}</p>
        <p><strong>Rent End:</strong> {{ $booking->rent_end_date }}</p>
        <p><strong>Car Type:</strong> {{ ucfirst($booking->car_type) }}</p>
        <p><strong>Charge Type:</strong> {{ ucfirst($booking->charge_type) }}</p>
        @if($booking->charge_type==='km')
        <p><strong>Distance/KM:</strong> {{ $booking->distance }}</p>
        @endif
        <p><strong>Fare:</strong> ${{ number_format($booking->fare,2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    </div>

    <button onclick="window.print()" class="btn btn-success mt-3">Print Invoice</button>
    <a href="{{ route('bookings.index') }}" class="btn btn-primary mt-3">Back to Bookings</a>
</div>
@endsection

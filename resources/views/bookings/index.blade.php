@extends('layouts.app')

@section('title','Bookings')

@section('content')
<div class="container py-4 w-100" style="margin-left:250px;">
    <h3 class="mb-4">📋 Bookings</h3>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('bookings.index') }}" class="mb-4 row g-3">
        <div class="col-md-3">
            <input type="text" name="customer" class="form-control" placeholder="Customer Name" value="{{ $filters['customer'] ?? '' }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="vehicle" class="form-control" placeholder="Vehicle Name" value="{{ $filters['vehicle'] ?? '' }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Select Status --</option>
                <option value="pending" {{ (isset($filters['status']) && $filters['status']=='pending') ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ (isset($filters['status']) && $filters['status']=='completed') ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ (isset($filters['status']) && $filters['status']=='cancelled') ? 'selected' : '' }}>Cancelled</option>
                <option value="paid" {{ (isset($filters['status']) && $filters['status']=='paid') ? 'selected' : '' }}>Paid</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('bookings.create') }}" class="btn btn-success">+ New Booking</a>
        </div>
    </form>

    <!-- Booking Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Driver</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Type</th>
                    <th>Charge</th>
                    <th>Distance (KM)</th>
                    <th>Fare</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->customer->name ?? '-' }}</td>
                    <td>{{ $booking->vehicle->name ?? '-' }}</td>
                    <td>{{ $booking->driver->name ?? '-' }}</td>
                    <td>{{ $booking->start_datetime }}</td>
                    <td>{{ $booking->end_datetime }}</td>
                    <td>{{ strtoupper($booking->car_type) }}</td>
                    <td>{{ strtoupper($booking->charge_type) }}</td>
                    <td>{{ $booking->distance ?? '-' }}</td>
                    <td>{{ $booking->fare }}</td>
                    <td>
                        @if($booking->status=='pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($booking->status=='completed')
                        <span class="badge bg-success">Completed</span>
                        @elseif($booking->status=='cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                        @elseif($booking->status=='paid')
                        <span class="badge bg-info text-dark">Paid</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('bookings.edit',$booking->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <a href="{{ route('bookings.invoice',$booking->id) }}" target="_blank" class="btn btn-sm btn-secondary">Invoice</a>
                        <form action="{{ route('bookings.destroy',$booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
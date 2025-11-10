@extends('layouts.app')
@section('title','Bookings')

@section('content')
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">📋 Bookings</h3>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm">+ New Booking</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Car</th>
                        <th>Driver</th>
                        <th>Customer</th>
                        <th>Rent Start</th>
                        <th>Rent End</th>
                        <th>Car Type</th>
                        <th>Charge Type</th>
                        <th>Distance/KM</th>
                        <th>Fare</th>
                        <th>Status</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $booking->vehicle->name }}</td>
                        <td>{{ $booking->driver->name ?? 'N/A' }}</td>
                        <td>{{ $booking->customer->name }}</td>
                        <td>{{ $booking->start_datetime }}</td>
                        <td>{{ $booking->end_datetime }}</td>
                        <td>{{ ucfirst($booking->car_type) }}</td>
                        <td>{{ ucfirst($booking->charge_type) }}</td>
                        <td>{{ $booking->distance?? '-' }}</td>
                        <td>${{ number_format($booking->fare,2) }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td class="d-flex gap-1">
                            <!-- Edit Button -->
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1" onclick="return confirm('Are you sure you want to delete this booking?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>

                            <!-- Print Button -->
                            <a href="{{ route('bookings.invoice', $booking->id) }}" target="_blank" class="btn btn-sm btn-success d-flex align-items-center gap-1">
                                <i class="bi bi-printer"></i> Print
                            </a>
                        </td>



                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted py-3">No bookings found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
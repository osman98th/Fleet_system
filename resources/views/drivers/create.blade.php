@extends('layouts.app')

@section('title', 'Add Driver')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">🚚 Add New Driver</h3>
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-sm">← Back to Driver List</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('drivers.store') }}" method="POST" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">License Number</label>
                    <input type="text" name="license_number" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Assign Vehicle</label>
                    <select name="vehicle_id" class="form-select">
                        <option value="" selected disabled>-- Select Vehicle --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }} ({{ $vehicle->type }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Route</label>
                    <input type="text" name="route" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Available" selected>Available</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">💾 Save Driver</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

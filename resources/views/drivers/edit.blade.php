@extends('layouts.app')

@section('title', 'Edit Driver')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">✏️ Edit Driver</h3>
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-sm">← Back to Driver List</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('drivers.update', $driver->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $driver->name }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">License Number</label>
                    <input type="text" name="license_number" class="form-control" value="{{ $driver->license_number }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $driver->phone }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ $driver->address }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Assign Vehicle</label>
                    <select name="vehicle_id" class="form-select">
                        <option value="" disabled>-- Select Vehicle --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ $driver->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->name }} ({{ $vehicle->type }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Route</label>
                    <input type="text" name="route" class="form-control" value="{{ $driver->route }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Available" {{ $driver->status == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Inactive" {{ $driver->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">✅ Update Driver</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

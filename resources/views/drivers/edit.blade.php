@extends('layouts.app')
@section('title', 'Edit Driver')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Driver</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Driver ID -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Driver ID</label>
                        <input type="text" name="driver_id" value="{{ $driver->driver_id }}" class="form-control" required>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Driver Name</label>
                        <input type="text" name="name" value="{{ $driver->name }}" class="form-control" required>
                    </div>

                    <!-- License Number -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">License Number</label>
                        <input type="text" name="license_number" value="{{ $driver->license_number }}" class="form-control" required>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ $driver->phone }}" class="form-control" required>
                    </div>

                    <!-- Address -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control">{{ $driver->address }}</textarea>
                    </div>

                    <!-- Vehicle Type -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle Type</label>
                        <select name="vehicle_type" class="form-select" required>
                            <option disabled>Choose Vehicle Type</option>
                            <option {{ $driver->vehicle_type == 'Truck' ? 'selected' : '' }}>Truck</option>
                            <option {{ $driver->vehicle_type == 'Bus' ? 'selected' : '' }}>Bus</option>
                            <option {{ $driver->vehicle_type == 'Car' ? 'selected' : '' }}>Car</option>
                            <option {{ $driver->vehicle_type == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                        </select>
                    </div>

                    <!-- Route -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Route</label>
                        <select name="route" class="form-select" required>
                            <option disabled>Choose Route</option>
                            <option {{ $driver->route == 'Dhaka → Barishal' ? 'selected' : '' }}>Dhaka → Barishal</option>
                            <option {{ $driver->route == 'Dhaka → Chattogram' ? 'selected' : '' }}>Dhaka → Chattogram</option>
                            <option {{ $driver->route == 'Dhaka → Sylhet' ? 'selected' : '' }}>Dhaka → Sylhet</option>
                            <option {{ $driver->route == 'Dhaka → Rajshahi' ? 'selected' : '' }}>Dhaka → Rajshahi</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option {{ $driver->status == 'Available' ? 'selected' : '' }}>Available</option>
                            <option {{ $driver->status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning text-white mt-2">Update Driver</button>
            </form>
        </div>
    </div>
</div>
@endsection

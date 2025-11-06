@extends('layouts.app')
@section('title', 'Add Vehicle')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">🚗 Add New Vehicle</h3>
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-sm">← Back to List</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('vehicles.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="vehicle_name" class="form-label">Vehicle Name</label>
                    <input type="text" name="name" id="vehicle_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" name="model" id="model" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="license_plate" class="form-label">License Plate</label>
                    <input type="text" name="license_plate" id="license_plate" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" name="manufacture_year" id="year" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-label">Vehicle Type</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="Car">Car</option>
                        <option value="Truck">Truck</option>
                        <option value="Bus">Bus</option>
                        <option value="Van">Van</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">💾 Save Vehicle</button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

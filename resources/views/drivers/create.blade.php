@extends('layouts.app')
@section('title', 'Add New Driver')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Driver</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('drivers.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Driver ID -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Driver ID</label>
                        <input type="text" name="driver_id" class="form-control" placeholder="e.g. DR-102" required>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Driver Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Driver Full Name" required>
                    </div>

                    <!-- License Number -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">License Number</label>
                        <input type="text" name="license_number" class="form-control" placeholder="License Number" required>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                    </div>

                    <!-- Address -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" placeholder="Enter Address"></textarea>
                    </div>

                    <!-- Vehicle Type -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle Type</label>
                        <select name="vehicle_type" class="form-select" required>
                            <option selected disabled>Choose Vehicle Type</option>
                            <option>Truck</option>
                            <option>Bus</option>
                            <option>Car</option>
                            <option>Pickup</option>
                        </select>
                    </div>

                    <!-- Route -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Route</label>
                        <select name="route" class="form-select" required>
                            <option selected disabled>Choose Route</option>
                            <option>Dhaka → Barishal</option>
                            <option>Dhaka → Chattogram</option>
                            <option>Dhaka → Sylhet</option>
                            <option>Dhaka → Rajshahi</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option>Available</option>
                            <option>Unavailable</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Save Driver</button>
            </form>
        </div>
    </div>
</div>
@endsection

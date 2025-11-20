@extends('layouts.app')

@section('title','Add Cost')

@section('content')
<div class="container py-4">
    <h3>➕ Add Cost</h3>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('costs.store') }}" method="POST">
                @csrf

                {{-- Vehicle Dropdown --}}
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id" class="form-select" required>
                        <option value="">-- Select Vehicle --</option>
                        @foreach(\App\Models\Vehicle::orderBy('name')->get() as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Cost Type Dropdown --}}
                <div class="mb-3">
                    <label for="type" class="form-label">Cost Type</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        <option value="Fuel">Fuel</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Per Trip">Per Trip</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Parking">Parking</option>
                        <option value="Toll">Toll</option>
                    </select>
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Cost Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                {{-- Amount --}}
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (৳)</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                </div>

                {{-- Date --}}
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('costs.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    {{-- Vehicle Profit PDF --}}
    <div class="mt-4">
        <h5>Generate Vehicle Profit PDF</h5>
        <form action="" id="pdfForm">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <select id="vehiclePdf" class="form-select">
                        <option value="">-- Select Vehicle --</option>
                        @foreach(\App\Models\Vehicle::orderBy('name')->get() as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" id="generatePdf">Download PDF</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('generatePdf').addEventListener('click', function() {
        var vehicleId = document.getElementById('vehiclePdf').value;
        if (!vehicleId) {
            alert('Please select a vehicle');
            return;
        }
        window.open('/costs/vehicle/' + vehicleId + '/profit-pdf', '_blank');
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Fuel Report</h2>

    <div class="row mb-3">
        <div class="col-md-4">
            <select id="vehicleFilter" class="form-select">
                <option value="">Select Vehicle</option>
                @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select id="driverFilter" class="form-select">
                <option value="">Select Driver</option>
                @foreach($drivers as $driver)
                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button id="filterBtn" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="fuelTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Quantity</th>
                        <th>Price (৳)</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data will be loaded via AJAX --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function loadFuelData(vehicle_id = '', driver_id = '') {
        $.ajax({
            url: "{{ route('dashboard.filterFuel') }}",
            type: 'GET',
            data: {
                vehicle_id,
                driver_id
            },
            success: function(data) {
                let rows = '';
                data.forEach((fuel, index) => {
                    rows += `<tr>
                        <td>${index + 1}</td>
                        <td>${fuel.vehicle_name}</td>
                        <td>${fuel.driver_name}</td>
                        <td>${fuel.quantity}</td>
                        <td>${fuel.price}</td>
                        <td>${fuel.date}</td>
                    </tr>`;
                });
                $('#fuelTable tbody').html(rows);
            }
        });
    }

    $(document).ready(function() {
        // Initial load
        loadFuelData();

        // Filter button click
        $('#filterBtn').click(function() {
            const vehicle_id = $('#vehicleFilter').val();
            const driver_id = $('#driverFilter').val();
            loadFuelData(vehicle_id, driver_id);
        });
    });
</script>
@endsection
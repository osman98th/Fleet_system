@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-6 text-2xl font-bold">🚀 Dashboard Overview</h2>

    <!-- ==== Summary Cards ==== -->
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="p-4 bg-blue-500 text-white rounded shadow">
            <h3 class="font-semibold">Total Vehicles</h3>
            <p class="text-2xl">{{ $totalVehicles }}</p>
        </div>
        <div class="p-4 bg-green-500 text-white rounded shadow">
            <h3 class="font-semibold">Total Drivers</h3>
            <p class="text-2xl">{{ $totalDrivers }}</p>
        </div>
        <div class="p-4 bg-purple-500 text-white rounded shadow">
            <h3 class="font-semibold">Total Assignments</h3>
            <p class="text-2xl">{{ $totalAssignments }}</p>
        </div>
        <div class="p-4 bg-yellow-500 text-white rounded shadow">
            <h3 class="font-semibold">Total Fuel Records</h3>
            <p class="text-2xl">{{ $totalFuelRecords }}</p>
        </div>
    </div>

    <div class="space-y-10">

        <!-- Vehicles Table -->
        <div>
            <h3 class="text-xl font-semibold mb-2">Recent Vehicles</h3>
            @include('partials.vehicles-table')
        </div>

        <!-- Drivers Table -->
        <div>
            <h3 class="text-xl font-semibold mb-2">Recent Drivers</h3>
            @include('partials.drivers-table')
        </div>

        <!-- Assignments Table -->
        <div>
            <h3 class="text-xl font-semibold mb-2">Recent Assignments</h3>
            @include('partials.assignments-table')
        </div>

    </div>

    <!-- Optional: Fuel Chart -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold mb-4">Fuel Usage by Month</h3>
        <canvas id="fuelChart" width="400" height="150"></canvas>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('fuelChart').getContext('2d');
    const fuelChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($fuelChart)) !!},
            datasets: [{
                label: 'Fuel Liters',
                data: {!! json_encode(array_values($fuelChart)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection

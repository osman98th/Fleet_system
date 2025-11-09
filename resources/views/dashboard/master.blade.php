<!-- {{-- resources/views/dashboard/master.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $pageTitle ?? 'Dashboard' }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Vehicles</h6>
                        <h3 class="card-text">{{ $totalVehicles ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Total Drivers</h6>
                        <h3 class="card-text">{{ $totalDrivers ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Assignments</h6>
                        <h3 class="card-text">{{ $totalAssignments ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Fuel Records</h6>
                        <h3 class="card-text">{{ $totalFuelRecords ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fuel Section --}}
        @if($showFuelSection ?? false)
        <div class="card mb-4 shadow">
            <div class="card-header font-weight-bold">Fuel Reports</div>
            <div class="card-body">

                {{-- Filters --}}
                <div class="row mb-3 g-2">
                    <div class="col-md-4">
                        <select id="vehicleFilter" class="form-select">
                            <option value="">All Vehicles</option>
                            @foreach($vehicles ?? [] as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="driverFilter" class="form-select">
                            <option value="">All Drivers</option>
                            @foreach($drivers ?? [] as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button id="filterBtn" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>

                {{-- Fuel Table --}}
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-bordered" id="fuelTable">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle</th>
                                <th>Driver</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                {{-- Fuel Chart --}}
                <canvas id="fuelChart" height="100"></canvas>
            </div>
        </div>
        @endif

        {{-- Latest Bookings Section --}}
        @if($showBookingsSection ?? false)
        <div class="card mb-4 shadow">
            <div class="card-header font-weight-bold">Latest Bookings</div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" id="latestBookingsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Car Type</th>
                            <th>Charge Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings ?? [] as $booking)
                        <tr>
                            <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                            <td>{{ $booking->vehicle->name ?? 'N/A' }}</td>
                            <td>{{ $booking->driver->name ?? 'Unassigned' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->start_datetime)->format('d M Y H:i') }}</td>
                            <td>{{ $booking->end_datetime ? \Carbon\Carbon::parse($booking->end_datetime)->format('d M Y H:i') : '-' }}</td>
                            <td>{{ ucfirst($booking->car_type) }}</td>
                            <td>{{ ucfirst($booking->charge_type) }}</td>
                            <td>{{ ucfirst($booking->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>

    @push('scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if($showFuelSection ?? false)
        let ctx = document.getElementById('fuelChart').getContext('2d');
        let fuelChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($fuelChartLabels ?? []),
                datasets: [{
                    label: 'Fuel Quantity (Litre)',
                    data: @json($fuelChartData ?? []),
                    borderColor: 'rgba(59,130,246,1)',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function loadFuelData(vehicle = '', driver = '') {
            fetch(`/fuel-reports/filter?vehicle_id=${vehicle}&driver_id=${driver}`)
                .then(res => res.json())
                .then(res => {
                    let tbody = document.querySelector('#fuelTable tbody');
                    tbody.innerHTML = '';
                    res.table.forEach(row => {
                        tbody.innerHTML += `<tr>
                            <td>${row.vehicle_name}</td>
                            <td>${row.driver_name}</td>
                            <td>${row.quantity}</td>
                            <td>${row.price}</td>
                            <td>${row.date}</td>
                        </tr>`;
                    });

                    fuelChart.data.labels = res.chart.labels;
                    fuelChart.data.datasets[0].data = res.chart.data;
                    fuelChart.update();
                });
        }

        document.getElementById('filterBtn').addEventListener('click', () => {
            let vehicle = document.getElementById('vehicleFilter').value;
            let driver = document.getElementById('driverFilter').value;
            loadFuelData(vehicle, driver);
        });

        // Initial load
        loadFuelData();
        @endif
    </script>
    @endpush
</x-app-layout> -->
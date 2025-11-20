@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="container-fluid py-4 d-flex flex-column min-vh-100">

    <h2 class="mb-4">🚀 Fleet Management Dashboard</h2>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        @php
        $cards = [
        ['title'=>'Vehicles','count'=>$totalVehicles,'icon'=>'bi-truck','bg'=>'bg-primary'],
        ['title'=>'Drivers','count'=>$totalDrivers,'icon'=>'bi-person-badge','bg'=>'bg-success'],
        ['title'=>'Assignments','count'=>$totalAssignments,'icon'=>'bi-link','bg'=>'bg-warning'],
        ['title'=>'Fuel Records','count'=>$totalFuelRecords,'icon'=>'bi-fuel-pump','bg'=>'bg-info'],
        ['title'=>'Monthly Cost','count'=>$totalMonthlyCost,'icon'=>'bi-cash-stack','bg'=>'bg-danger'],
        ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-3">
            <div class="card shadow-sm text-white {{ $card['bg'] }} h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">{{ $card['title'] }}</h6>
                        <h4>{{ number_format($card['count'], 2) }}</h4>
                    </div>
                    <i class="bi {{ $card['icon'] }} fs-1"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filters -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <select id="filterVehicle" class="form-select shadow-sm">
                <option value="">-- All Vehicles --</option>
                @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterDriver" class="form-select shadow-sm">
                <option value="">-- All Drivers --</option>
                @foreach($drivers as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">⛽ Fuel Cost (Last 7 Days)</h5>
                    <canvas id="fuelChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">💰 Cost (Last 7 Days)</h5>
                    <canvas id="costChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Fuel Records -->
    <div class="row mb-4 flex-grow-1">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">⛽ Recent Fuel Records</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Cost (৳)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="fuelTableBody">
                                @foreach($recentFuels as $fuel)
                                <tr>
                                    <td>{{ $fuel->vehicle->name ?? 'N/A' }}</td>
                                    <td>{{ $fuel->driver->name ?? 'Unassigned' }}</td>
                                    <td>{{ number_format($fuel->cost,2) }}</td>
                                    <td>{{ $fuel->date->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Charts
    const fuelCtx = document.getElementById('fuelChart').getContext('2d');
    const costCtx = document.getElementById('costChart').getContext('2d');

    const fuelChart = new Chart(fuelCtx, {
        type: 'line',
        data: {
            labels: {
                !!json_encode($fuelChartLabels) !!
            },
            datasets: [{
                label: 'Fuel Cost (৳)',
                data: {
                    !!json_encode($fuelChartData) !!
                },
                backgroundColor: 'rgba(54,162,235,0.2)',
                borderColor: 'rgba(54,162,235,1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true
        }
    });

    const costChart = new Chart(costCtx, {
        type: 'bar',
        data: {
            labels: {
                !!json_encode($costChartLabels) !!
            },
            datasets: [{
                label: 'Cost Amount (৳)',
                data: {
                    !!json_encode($costChartData) !!
                },
                backgroundColor: 'rgba(255,99,132,0.6)',
                borderColor: 'rgba(255,99,132,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // AJAX Filter
    async function loadChartsData() {
        const vehicle_id = document.getElementById("filterVehicle").value;
        const driver_id = document.getElementById("filterDriver").value;

        try {
            const fuelRes = await fetch(`{{ route('dashboard.filterFuel') }}?vehicle_id=${vehicle_id}&driver_id=${driver_id}`);
            const fuelData = await fuelRes.json();

            const fuelLabels = [];
            const fuelCosts = [];
            let tbody = '';

            fuelData.forEach(r => {
                tbody += `<tr>
                    <td>${r.vehicle}</td>
                    <td>${r.driver}</td>
                    <td>${r.cost}</td>
                    <td>${r.date}</td>
                </tr>`;
                fuelLabels.push(r.date);
                fuelCosts.push(r.cost);
            });

            document.getElementById("fuelTableBody").innerHTML = tbody;
            fuelChart.data.labels = fuelLabels;
            fuelChart.data.datasets[0].data = fuelCosts;
            fuelChart.update();

            // Costs
            const costRes = await fetch(`{{ route('dashboard.filterCost') }}?vehicle_id=${vehicle_id}&driver_id=${driver_id}`);
            const costData = await costRes.json();

            const costLabels = [];
            const costAmounts = [];

            costData.forEach(r => {
                costLabels.push(r.date);
                costAmounts.push(r.amount);
            });

            costChart.data.labels = costLabels;
            costChart.data.datasets[0].data = costAmounts;
            costChart.update();

        } catch (error) {
            console.error("Error fetching charts data:", error);
        }
    }

    document.getElementById("filterVehicle").addEventListener("change", loadChartsData);
    document.getElementById("filterDriver").addEventListener("change", loadChartsData);
</script>
@endsection
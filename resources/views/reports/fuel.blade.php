@extends('layouts.app')
@section('title', 'Fuel Expense Report')

@section('content')
<div class="dashboard">
    <h2>Fuel Expense Report</h2>

    <div class="report-summary">
        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Total Liters</th>
                    <th>Total Cost</th>
                    <th>Avg. Cost/Liter</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $r)
                <tr>
                    <td>{{ $r->vehicle->vehicle_name ?? 'N/A' }}</td>
                    <td>{{ number_format($r->total_liters, 2) }}</td>
                    <td>${{ number_format($r->total_cost, 2) }}</td>
                    <td>${{ number_format($r->avg_cost_per_liter, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="chart-section">
        <h3>Daily Fuel Expense Chart</h3>
        <canvas id="fuelChart" width="800" height="350"></canvas>
    </div>
</div>

<script>
    // Fuel Chart Data from Laravel
    const dailyLabels = {!! json_encode($dailyData->pluck('date')) !!};
    const dailyCosts = {!! json_encode($dailyData->pluck('daily_cost')) !!};

    const ctx = document.getElementById('fuelChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Daily Fuel Cost ($)',
                data: dailyCosts,
                borderColor: '#007bff',
                fill: false,
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: { display: true, text: 'Fuel Expense Over Time', font: { size: 16 } }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Cost ($)' } },
                x: { title: { display: true, text: 'Date' } }
            }
        }
    });
</script>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

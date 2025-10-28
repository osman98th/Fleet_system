@extends('layouts.app')
@section('title', 'Dashboard Overview')

@section('content')
<div class="dashboard">
    <h2>Dashboard Overview</h2>

    <!-- ==== Top Summary Cards ==== -->
    <div class="summary-cards">
        <div class="card">
            <h3>Total Vehicles</h3>
            <p>{{ $totalVehicles }}</p>
        </div>
        <div class="card">
            <h3>Total Drivers</h3>
            <p>{{ $totalDrivers }}</p>
        </div>
        <div class="card">
            <h3>Total Fuel Cost</h3>
            <p>${{ number_format($totalFuelCost, 2) }}</p>
        </div>
        <div class="card">
            <h3>Avg. Fuel Cost</h3>
            <p>${{ number_format($avgFuelCost, 2) }}</p>
        </div>
    </div>

    <!-- ==== Chart Section ==== -->
    <div class="chart-section">
        <h3>Fuel Cost (Last 7 Days)</h3>
        <canvas id="fuelChart" width="800" height="350"></canvas>
    </div>

    <!-- ==== Recent Activity Section ==== -->
    <div class="recent-activities">
        <h3>Recent Activities</h3>

        <div class="activity-grid">
            <div class="activity-card">
                <h4>🆕 New Vehicles</h4>
                <table>
                    <thead><tr><th>Vehicle Name</th><th>Added On</th></tr></thead>
                    <tbody>
                        @forelse($recentVehicles as $v)
                        <tr>
                            <td>{{ $v->vehicle_name }}</td>
                            <td>{{ $v->created_at->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2">No records found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="activity-card">
                <h4>👨‍✈️ New Drivers</h4>
                <table>
                    <thead><tr><th>Driver Name</th><th>Joined On</th></tr></thead>
                    <tbody>
                        @forelse($recentDrivers as $d)
                        <tr>
                            <td>{{ $d->driver_name }}</td>
                            <td>{{ $d->created_at->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2">No records found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="activity-card">
                <h4>⛽ Recent Fuel Entries</h4>
                <table>
                    <thead><tr><th>Date</th><th>Liters</th><th>Cost</th></tr></thead>
                    <tbody>
                        @forelse($recentFuel as $f)
                        <tr>
                            <td>{{ $f->date }}</td>
                            <td>{{ $f->liters }}</td>
                            <td>${{ number_format($f->cost, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3">No fuel data yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = {!! json_encode($chartData->pluck('date')) !!};
const values = {!! json_encode($chartData->pluck('total_cost')) !!};

const ctx = document.getElementById('fuelChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Fuel Cost ($)',
            data: values,
            backgroundColor: '#007bff',
            borderRadius: 5
        }]
    },
    options: {
        plugins: {
            title: { display: true, text: 'Last 7 Days Fuel Cost Summary', font: { size: 16 } }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

<style>
.dashboard { padding: 10px; }

/* Summary Cards */
.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}
.card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    text-align: center;
    padding: 20px;
    transition: transform 0.2s;
}
.card:hover { transform: scale(1.03); }
.card h3 { color: #002855; font-size: 18px; }
.card p { font-size: 22px; color: #007bff; margin: 5px 0 0 0; }

/* Chart Section */
.chart-section {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

/* Recent Activities */
.recent-activities h3 {
    color: #002855;
    margin-bottom: 15px;
}
.activity-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}
.activity-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 15px;
}
.activity-card h4 {
    margin-bottom: 10px;
    color: #007bff;
}
.activity-card table {
    width: 100%;
    border-collapse: collapse;
}
.activity-card th, .activity-card td {
    border-bottom: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
.activity-card th {
    background-color: #f0f4f8;
    color: #002855;
}
.activity-card tr:hover { background-color: #f9fbff; }
</style>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Overview
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- ==== Dashboard Content ==== -->
                    <div class="dashboard">
                        <h2>Dashboard Overview</h2>

                        <!-- ==== Top Summary Cards ==== -->
                        <div class="summary-cards">
                            <div class="card">
                                <h3>Total Vehicles</h3>
                                <p>{{ $totalVehicles ?? 0 }}</p>
                            </div>
                            <div class="card">
                                <h3>Total Drivers</h3>
                                <p>{{ $totalDrivers ?? 0 }}</p>
                            </div>
                            <div class="card">
                                <h3>Total Fuel Cost</h3>
                                <p>${{ number_format($totalFuelCost ?? 0, 2) }}</p>
                            </div>
                            <div class="card">
                                <h3>Avg. Fuel Cost</h3>
                                <p>${{ number_format($avgFuelCost ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <!-- ==== Fleet Management Circular Layout ==== -->
                        <div class="fleet-features-circle">
                            <h3>Top Features of the Fleet Management System</h3>
                            <div class="circle-container">
                                <!-- Center Icon -->
                                <div class="center-icon">
                                    <img src="{{ asset('images/fms.png') }}" alt="Fleet Icon">
                                </div>

                                <!-- Feature items placed around the circle -->
                                <div class="feature-item item1">Dynamic Admin Panel</div>
                                <div class="feature-item item2">User Management System</div>
                                <div class="feature-item item3">GPS Tracking System</div>
                                <div class="feature-item item4">Fuel Management</div>
                                <div class="feature-item item5">Financial Management System</div>
                                <div class="feature-item item6">Human Resource Management System</div>
                                <div class="feature-item item7">Inventory Management System</div>
                                <div class="feature-item item8">Service Management</div>
                                <div class="feature-item item9">Vehicle Assignment System</div>
                                <div class="feature-item item10">Reporting System</div>
                                <div class="feature-item item11">Real-Time Notification System</div>
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
                                <!-- Vehicles -->
                                <div class="activity-card">
                                    <h4>🆕 New Vehicles</h4>
                                    <table>
                                        <thead>
                                            <tr><th>Vehicle Name</th><th>Added On</th></tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentVehicles ?? [] as $v)
                                            <tr>
                                                <td>{{ $v->vehicle_name ?? 'N/A' }}</td>
                                                <td>{{ isset($v->created_at) ? \Carbon\Carbon::parse($v->created_at)->format('d M, Y') : 'N/A' }}</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="2">No records found</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Drivers -->
                                <div class="activity-card">
                                    <h4>👨‍✈️ New Drivers</h4>
                                    <table>
                                        <thead><tr><th>Driver Name</th><th>Joined On</th></tr></thead>
                                        <tbody>
                                            @forelse($recentDrivers ?? [] as $d)
                                            <tr>
                                                <td>{{ $d->driver_name ?? 'N/A' }}</td>
                                                <td>{{ isset($d->created_at) ? \Carbon\Carbon::parse($d->created_at)->format('d M, Y') : 'N/A' }}</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="2">No records found</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Fuel -->
                                <div class="activity-card">
                                    <h4>⛽ Recent Fuel Entries</h4>
                                    <table>
                                        <thead><tr><th>Date</th><th>Liters</th><th>Cost</th></tr></thead>
                                        <tbody>
                                            @forelse($recentFuel ?? [] as $f)
                                            <tr>
                                                <td>{{ isset($f->date) ? \Carbon\Carbon::parse($f->date)->format('d M, Y') : 'N/A' }}</td>
                                                <td>{{ $f->liters ?? 0 }}</td>
                                                <td>${{ number_format($f->cost ?? 0, 2) }}</td>
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
                        const chartData = [
                          { date: '2025-10-25', total_cost: 500 },
                          { date: '2025-10-26', total_cost: 750 },
                          { date: '2025-10-27', total_cost: 300 },
                          { date: '2025-10-28', total_cost: 900 },
                        ];

                        const labels = chartData.map(item => new Date(item.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short' }));
                        const values = chartData.map(item => item.total_cost ?? 0);

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
                                plugins: { title: { display: true, text: 'Last 7 Days Fuel Cost Summary', font: { size: 16 } } },
                                scales: { y: { beginAtZero: true } }
                            }
                        });
                    </script>

                    <!-- Dashboard CSS -->
                    <style>
                        .dashboard { padding: 10px; }

                        /* Summary Cards */
                        .summary-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px; }
                        .card { background: white; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-align: center; padding: 20px; transition: transform 0.2s; }
                        .card:hover { transform: scale(1.03); }
                        .card h3 { color: #002855; font-size: 18px; }
                        .card p { font-size: 22px; color: #007bff; margin: 5px 0 0 0; }

                        /* Fleet Features Circular Layout */
                        .fleet-features-circle { background: #fff; border-radius: 12px; padding: 40px 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 50px; text-align: center; position: relative; }
                        .fleet-features-circle h3 { color: #002855; margin-bottom: 40px; font-size: 22px; font-weight: 700; }
                        .circle-container { position: relative; width: 500px; height: 500px; margin: 0 auto; border: 2px dashed #007bff3a; border-radius: 50%; }
                        .center-icon { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #007bff; border-radius: 50%; width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
                        .center-icon img { width: 80px; height: 80px; object-fit: contain; }
                        .feature-item { position: absolute; background: #f0f4f8; color: #007bff; font-weight: 600; padding: 10px 14px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); width: 180px; text-align: center; transition: all 0.3s ease; }
                        .feature-item:hover { background: #007bff; color: #fff; transform: scale(1.05); }

                        /* Positions around circle */
                        .item1  { top: 0%;   left: 50%; transform: translate(-50%, -50%); }
                        .item2  { top: 10%;  right: 10%; transform: translate(50%, 0); }
                        .item3  { top: 30%;  right: 0%; transform: translate(50%, 0); }
                        .item4  { top: 55%;  right: 0%; transform: translate(50%, -50%); }
                        .item5  { top: 75%;  right: 10%; transform: translate(50%, 0); }
                        .item6  { bottom: 0%; left: 50%; transform: translate(-50%, 50%); }
                        .item7  { top: 75%;  left: 10%; transform: translate(-50%, 0); }
                        .item8  { top: 55%;  left: 0%; transform: translate(-50%, -50%); }
                        .item9  { top: 30%;  left: 0%; transform: translate(-50%, 0); }
                        .item10 { top: 10%;  left: 10%; transform: translate(-50%, 0); }
                        .item11 { top: -5%;  left: 50%; transform: translate(-50%, -50%); }

                        /* Chart Section */
                        .chart-section { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 40px; }

                        /* Recent Activities */
                        .recent-activities h3 { color: #002855; margin-bottom: 15px; }
                        .activity-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
                        .activity-card { background: white; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 15px; }
                        .activity-card h4 { margin-bottom: 10px; color: #007bff; }
                        .activity-card table { width: 100%; border-collapse: collapse; overflow-x: auto; display: block; }
                        .activity-card th, .activity-card td { border-bottom: 1px solid #ddd; padding: 8px; text-align: left; }
                        .activity-card th { background-color: #f0f4f8; color: #002855; }
                        .activity-card tr:hover { background-color: #f9fbff; }

                        /* Responsive */
                        @media (max-width: 768px) {
                            .circle-container { width: 320px; height: 320px; }
                            .center-icon { width: 80px; height: 80px; }
                            .center-icon img { width: 55px; height: 55px; }
                            .feature-item { width: 130px; font-size: 12px; padding: 8px; }
                        }
                    </style>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

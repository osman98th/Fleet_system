@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="container-fluid py-4 d-flex flex-column min-vh-100">

    <!-- Dark/Light Mode -->
    <div class="d-flex justify-content-end mb-3">
        <button id="themeToggle" class="btn btn-outline-secondary btn-sm">🌙 Dark Mode</button>
    </div>

    <h2 class="mb-4">🚀Fleet Management Dashboard</h2>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        @php
        $cards = [
            ['title'=>'Vehicles','count'=>$totalVehicles,'icon'=>'bi-truck','bg'=>'bg-primary'],
            ['title'=>'Drivers','count'=>$totalDrivers,'icon'=>'bi-person-badge','bg'=>'bg-success'],
            ['title'=>'Assignments','count'=>$totalAssignments,'icon'=>'bi-link','bg'=>'bg-warning'],
            ['title'=>'Fuel Records','count'=>$totalFuelRecords,'icon'=>'bi-fuel-pump','bg'=>'bg-danger'],
        ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md-3">
            <div class="card shadow-sm text-white {{ $card['bg'] }} h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">{{ $card['title'] }}</h5>
                        <h3>{{ $card['count'] }}</h3>
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

    <!-- Fuel Chart -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">⛽ Fuel Usage (Last 7 Days)</h5>
                    <canvas id="fuelChart" height="100"></canvas>
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
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="fuelTableBody">
                                @foreach($recentFuels as $fuel)
                                <tr>
                                    <td>{{ $fuel->vehicle->name ?? 'N/A' }}</td>
                                    <td>{{ $fuel->driver->name ?? 'Unassigned' }}</td>
                                    <td>{{ $fuel->quantity }}</td>
                                    <td>{{ number_format($fuel->price,2) }}</td>
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

    <!-- Sticky Footer -->
    <footer class="mt-auto py-3 bg-light border-top" style="position: sticky; bottom: 0; width: 100%;">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
            <span class="text-muted">Developed by Osman Goni</span>
        </div>
    </footer>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dark/Light Mode
    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click',()=>{
        document.body.classList.toggle('bg-dark');
        document.body.classList.toggle('text-light');
        themeToggle.textContent = document.body.classList.contains('bg-dark') ? '☀️ Light Mode' : '🌙 Dark Mode';
    });

    // Fuel Chart
    const ctx = document.getElementById('fuelChart').getContext('2d');
    const fuelChart = new Chart(ctx,{
        type:'line',
        data:{
            labels:{!! json_encode($fuelChartLabels) !!},
            datasets:[{
                label:'Fuel Quantity (L)',
                data:{!! json_encode($fuelChartData) !!},
                backgroundColor:'rgba(54,162,235,0.2)',
                borderColor:'rgba(54,162,235,1)',
                borderWidth:2,
                fill:true,
                tension:0.3
            }]
        },
        options:{
            responsive:true,
            plugins:{ legend:{ position:'top' } },
            scales:{
                x:{ title:{ display:true, text:'Date' } },
                y:{ beginAtZero:true, title:{ display:true, text:'Quantity (L)' } }
            }
        }
    });

    // AJAX Fuel Filter
    function loadFuelRecords(){
        let vehicle_id=document.getElementById("filterVehicle").value;
        let driver_id=document.getElementById("filterDriver").value;

        fetch("{{ route('dashboard.filterFuel') }}?vehicle_id="+vehicle_id+"&driver_id="+driver_id)
        .then(res=>res.json())
        .then(data=>{
            let tbody="", labels=[], qty=[];
            data.forEach(row=>{
                tbody+=`<tr>
                    <td>${row.vehicle}</td>
                    <td>${row.driver}</td>
                    <td>${row.quantity}</td>
                    <td>${row.price}</td>
                    <td>${row.date}</td>
                </tr>`;
                labels.push(row.date);
                qty.push(row.quantity);
            });
            document.getElementById("fuelTableBody").innerHTML=tbody;
            fuelChart.data.labels=labels;
            fuelChart.data.datasets[0].data=qty;
            fuelChart.update();
        });
    }
    document.getElementById("filterVehicle").addEventListener("change",loadFuelRecords);
    document.getElementById("filterDriver").addEventListener("change",loadFuelRecords);
</script>
@endsection

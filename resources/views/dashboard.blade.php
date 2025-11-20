@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<style>
    /* === Circular Features CSS === */

    #circleContainer {
        position: relative;
        overflow: visible !important;
    }

    #featureCircle div {
        position: absolute;
        background: linear-gradient(45deg, #0d6efd, #6610f2);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        transition: transform .3s ease, background .3s ease;
        z-index: 20;
    }

    #featureCircle div:hover {
        transform: scale(1.2) !important;
        background: linear-gradient(45deg, #ffc107, #fd7e14);
        color: black;
    }

    .car-center {
        z-index: 30;
        background: #fff;
        border-radius: 50%;
        border: 3px solid #0d6efd;
    }
</style>


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
        <div class="col-6 col-md-3">
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



    <!-- Circular Features Layout -->
    <div class="text-center mb-5">
        <h4 class="mb-3">Top Features of Fleet Management</h4>

        <div id="circleContainer"
            class="position-relative d-flex justify-content-center align-items-center mx-auto"
            style="width:90vw; max-width:400px; aspect-ratio:1/1;">

            <!-- Center Car Icon -->
            <div class="car-center shadow position-absolute d-flex justify-content-center align-items-center"
                style="width:30%; aspect-ratio:1/1;">
                <img src="https://cdn-icons-png.flaticon.com/512/7434/7434141.png"
                    class="img-fluid" style="width:60%; height:60%;">
            </div>

            <!-- Dynamic Circular Features -->
            <div id="featureCircle"
                class="position-absolute top-50 start-50 translate-middle w-100 h-100"></div>
        </div>
    </div>



    <!-- Recent Fuel Records -->
    <div class="row mb-4 flex-grow-1">
        <div class="col-12">
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
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // === Circular Features Data ===
        const features = [
            "Real-Time Notification", "Reporting System", "Vehicle Assignment",
            "Service Management", "Inventory Management", "Human Resource Management",
            "Dynamic Admin Panel", "User Management", "GPS Tracking",
            "Fuel Management", "Financial Management", "Inventory Control"
        ];

        const container = document.getElementById("featureCircle");

        function renderFeatures() {
            container.innerHTML = "";

            const diameter = container.offsetWidth;
            const radius = diameter / 2 - 45; // safe margin
            const angleStep = (2 * Math.PI) / features.length;

            features.forEach((feature, index) => {
                const angle = index * angleStep - Math.PI / 2;
                const x = radius * Math.cos(angle);
                const y = radius * Math.sin(angle);

                const div = document.createElement("div");
                div.textContent = feature;
                div.style.left = "50%";
                div.style.top = "50%";
                div.style.transform = `translate(${x}px, ${y}px) translate(-50%, -50%)`;

                container.appendChild(div);
            });
        }

        renderFeatures();
        window.addEventListener("resize", renderFeatures);
    });
</script>
@endsection
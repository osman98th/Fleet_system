<aside class="sidebar" id="sidebar">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                🏠 Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                🚗 Vehicles
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" href="{{ route('drivers.index') }}">
                👨‍✈️ Drivers
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}" href="{{ route('assignments.index') }}">
                🔁 Assignments
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('fuels.*') ? 'active' : '' }}" href="{{ route('reports.fuel') }}">
                ⛽ Total Fuel Expense
            </a>
        </li>

        <!-- ✅ Cost menu added -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('costs.*') ? 'active' : '' }}" href="{{ route('costs.index') }}">
                💰 Costs
                @if(isset($totalMonthlyCost))
                ({{ number_format($totalMonthlyCost, 2) }} ৳)
                @endif
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">
                📄 Bookings
            </a>
        </li>

    </ul>
</aside>
<aside class="sidebar" id="sidebar">
    <ul>
        <li><a href="{{ route('dashboard') }}">🏠 Dashboard</a></li>
        <li><a href="{{ route('vehicles.index') }}">🚗 Vehicles</a></li>
        <li><a href="{{ route('drivers.index') }}">👨‍✈️ Drivers</a></li>
        <li><a href="{{ route('assignments.index') }}">🔁 Assignments</a></li>
        <li>
            <a href="{{ route('reports.fuel') }}">
                💰 Total Expense
                @if(isset($totalExpense))
                ({{ number_format($totalExpense, 2) }} ৳)
                @endif
            </a>
        </li>
        <li><a href="{{ route('bookings.index') }}">📄 Booking</a></li>
    </ul>
</aside>
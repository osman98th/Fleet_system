<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Dashboard') - {{ config('app.name') }}</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome Free CDN (no integrity, no token) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: #343a40;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 60px;
            transition: 0.3s;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar ul li {
            margin-bottom: 0;
        }

        .sidebar ul li a {
            color: #ddd;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            font-size: 15px;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: #495057;
            color: #fff;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
            margin-top: 60px;
            transition: 0.3s;
        }

        @media(max-width:768px) {
            .sidebar {
                transform: translateX(-240px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0 !important;
            }
        }

        .sidebar-header {
            padding: 15px;
            font-size: 18px;
            color: #fff;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #495057;
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-light d-md-none" id="menuToggle">☰</button>
            <a class="navbar-brand ms-2" href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
            <div class="d-flex">
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-light me-2">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">Admin Panel</div>
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a></li>
            <li><a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">🚗 Vehicles</a></li>
            <li><a href="{{ route('drivers.index') }}" class="{{ request()->routeIs('drivers.*') ? 'active' : '' }}">👨‍✈️ Drivers</a></li>
            <li><a href="{{ route('assignments.index') }}" class="{{ request()->routeIs('assignments.*') ? 'active' : '' }}">🔁 Assignments</a></li>
            <li>
                <a href="{{ route('reports.fuel') }}" class="{{ request()->routeIs('reports.fuel') ? 'active' : '' }}">
                    💰 Total Expense
                    @if(isset($totalExpense))
                    ({{ number_format($totalExpense, 2) }} ৳)
                    @endif
                </a>
            </li>
            <li><a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">📄 Booking</a></li>
        </ul>
    </aside>

    <!-- Page Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        document.getElementById('menuToggle').addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    </script>

    @stack('scripts')
</body>

</html>
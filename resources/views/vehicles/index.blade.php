<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - My Fleet Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <aside class="col-md-2 col-lg-2 bg-light sidebar py-4">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">🏠 Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('vehicles.index') }}" class="nav-link">🚗 Vehicles</a></li>
                    <li class="nav-item"><a href="{{ route('drivers.index') }}" class="nav-link">👨‍✈️ Drivers</a></li>
                    <li class="nav-item"><a href="{{ route('assignments.index') }}" class="nav-link">🔁 Assignments</a></li>
                    <li class="nav-item"><a href="{{ route('fuels.index') }}" class="nav-link">⛽ Fuel Records</a></li>
                    <li class="nav-item"><a href="{{ route('reports.fuel') }}" class="nav-link">📊 Reports</a></li>
                    <li class="nav-item"><a href="{{ route('profile.edit') }}" class="nav-link">👤 Profile</a></li>
                </ul>
            </aside>

            <!-- Main Content -->
            <main class="col-md-10 col-lg-10 py-4">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy; {{ date('Y') }} My Fleet Management System
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <header class="bg-primary text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h4 class="mb-0">My Application</h4>
            <div>
                <span class="me-3">{{ auth()->user()->name ?? 'Guest' }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-light">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container-fluid flex-grow-1">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-2 col-lg-2 bg-light sidebar py-4 min-vh-100">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('profile.edit') }}" class="nav-link">Profile</a></li>


                    <li class="nav-item"><a href="{{ route('vehicles.index') }}" class="nav-link">Vehicles</a></li>

                    <li class="nav-item"><a href="#" class="nav-link">Drivers</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Fuel Records</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Reports</a></li>


                    
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 col-lg-10 py-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy; {{ date('Y') }} My Fleet Management System
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

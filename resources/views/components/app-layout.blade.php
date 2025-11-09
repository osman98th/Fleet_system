<div>
    <!-- Page Title -->
    <x-slot name="title">{{ $title ?? config('app.name', 'Laravel') }}</x-slot>

    <!-- Main wrapper -->
    <div class="min-vh-100 bg-light">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Header -->
        @if (isset($header))
        <header class="bg-white shadow-sm mb-4">
            <div class="container-fluid py-3">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="container-fluid px-4">
            {{ $slot }}
        </main>
    </div>

    <!-- Stacked Scripts -->
    @stack('scripts')
</div>
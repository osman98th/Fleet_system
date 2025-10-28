<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fleet Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    @include('partials.header')
    <div class="main-container">
        @include('partials.sidebar')
        <main class="content">
            @yield('content')
        </main>
    </div>
    @include('partials.footer')

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>

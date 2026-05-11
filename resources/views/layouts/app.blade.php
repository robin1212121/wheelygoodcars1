<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Wheely Good Cars') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .text-orange {
            color: orange !important;
        }
        body {
            background-color: #f8f9fa;
        }
        .navbar-dark .navbar-nav .nav-link.text-warning {
            color: orange !important;
        }
        .btn-warning {
            background-color: orange;
            border-color: orange;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark d-print-none bg-black mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <strong class="text-orange">Wheely</strong> good cars<strong class="text-orange">!</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="{{ route('cars.index') }}">Alle auto's</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="{{ route('cars.my') }}">Mijn aanbod</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="{{ route('cars.enterLicensePlate') }}">Aanbod plaatsen</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="{{ route('register') }}">Registreren</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="{{ route('login') }}">Inloggen</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Uitloggen
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
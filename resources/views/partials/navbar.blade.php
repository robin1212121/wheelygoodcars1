<nav class="navbar navbar-expand-md navbar-dark bg-black mb-4">
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
                    <a class="nav-link {{ request()->routeIs('cars.index') ? 'text-orange' : 'text-light' }}" href="{{ route('cars.index') }}">Alle auto's</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cars.my') ? 'text-orange' : 'text-light' }}" href="{{ route('cars.my') }}">Mijn aanbod</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cars.enterLicensePlate') ? 'text-orange' : 'text-light' }}" href="{{ route('cars.enterLicensePlate') }}">Aanbod plaatsen</a>
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
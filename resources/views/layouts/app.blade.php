<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('tittle')Little Movies Universe</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="{{ asset('css/myCSS.css') }}" rel="stylesheet">
    @yield('head')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom ">
            <div class="container">
                <a class="navbar-brand navbar-custom" href="{{ url('/') }}">
                    @yield('logo')Little Movies Universe
                </a>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Filmy</a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('showMovies') }}">Ranking filmów</a>
                            @auth
                                <a class="dropdown-item" href="{{ route('addMovieForm') }}">
                                    {{ __('Dodaj nowy film') }}
                                </a>
                            @endauth
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Artyści</a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('showArtists') }}">Wszyscy artyści</a>
                            @auth
                                <a class="dropdown-item" href="{{ route('addArtistForm') }}">
                                    {{ __('Dodaj nowego artystę') }}
                                </a>
                            @endauth
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler ms-3 customToggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" >
                    <i class="customToggler bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>
                    <form class="position-relative w-75" id="searchForm" method="get">
                        @csrf
                        <div class="d-flex g-0 mb-0 ms-4">
                            <input required class="form-control mx-2 w-75" type="search" placeholder="Wyszukaj" aria-label="Wyszukaj" id="searchInput" name="string" autocomplete="off">
                            <button type="submit" class="btn mt-2" id="searchButton"><h5><i class="bi bi-search searchIcon"></i></h5></button>
                        </div>
                        <ul id="searchResultsList" class="list-group mx-2 w-75">
                        </ul>
                    </form>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Logowanie') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Rejestracja') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ Auth::user()->image }}" alt="Profile Picture" class="rounded-circle user-image-little">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('showUser',['id'=>auth()->user()->id]) }}">
                                        {{ __('Profil użytkownika') }}
                                    </a>
                                    @if(auth()->user()->role=='admin')
                                        <a class="dropdown-item" href="{{ route('showAdminPanel') }}">
                                            {{ __('Panel administratora') }}
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wylogowanie') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="text-center py-2 pt-4 footer-custom">
        <div class="container">
            <p>&copy; 2024 Little Movies Universe</p>
        </div>
    </footer>
<script src="{{ asset('js/search.js') }}"></script>
</body>
</html>

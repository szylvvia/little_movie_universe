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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @yield('logo')Little Movies Universe
                </a>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Movies</a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('showMovies') }}">Show movies</a>
                            @auth
                                <a class="dropdown-item" href="{{ route('addMovieForm') }}">
                                    {{ __('Add new movie') }}
                                </a>
                            @endauth
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Artist</a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('showArtists') }}">Show artists</a>
                            @auth
                                <a class="dropdown-item" href="{{ route('addArtistForm') }}">
                                    {{ __('Add new artist') }}
                                </a>
                            @endauth
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>

                    <form class="position-relative w-75" id="searchForm" method="get" action="{{ route('search',['string'=>"string"]) }}">
                        @csrf
                        <div class="d-flex">
                            <input required class="form-control mx-2 w-75" type="search" placeholder="Search" aria-label="Search" id="searchInput" name="string" autocomplete="off">
                            <button type="submit" class="btn text-info" id="searchButton"><i class="bi bi-search"></i></button>
                        </div>
                        <ul id="searchResultsList" class="list-group mx-2 w-75">
                        </ul>
                    </form>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ Auth::user()->image }}" alt="Profile Picture" class="rounded-circle user-image-little">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('showUser',['id'=>auth()->user()->id]) }}">
                                        {{ __('Profile') }}
                                    </a>
                                    @if(auth()->user()->role=='admin')
                                        <a class="dropdown-item" href="{{ route('showAdminPanel') }}">
                                            {{ __('Admin Panel') }}
                                        </a>
                                    @endif
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

        <main class="py-4 mb-5">
            @yield('content')
        </main>
    </div>

    <footer class="bg-white text-dark text-center py-2 border-top shadow-sm fixed-bottom pt-3">
        <div class="container">
            <p>&copy; 2024 Little Movie Universe</p>
        </div>
    </footer>
<script src="{{ asset('js/search.js') }}"></script>
</body>
</html>

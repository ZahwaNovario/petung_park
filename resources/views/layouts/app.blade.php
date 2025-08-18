<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>@yield('title', 'Petung Park')</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        .navbar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-brand img {
            margin-right: 10px;
        }

        .custom-navbar {
            --bs-navbar-color: rgba(255, 255, 255, .85) !important;
            --bs-navbar-hover-color: rgba(255, 255, 255) !important;
            background-color: #295A3F;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark custom-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('/images/footer/logoPetungPark.png') }}" alt="Logo" width="40"
                        height="40" class="d-inline-block">
                    Petung Park
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('beranda') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('wisata') }}">Wisata</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('agenda') }}">Agenda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tentangKami') }}">Tentang Kami</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item d-none d-lg-block">
                                <span class="nav-link text-white">Welcome, {{ Auth::user()->name }}!</span>
                            </li>
                            <li class="nav-item d-lg-none">
                                <span class="nav-link text-white">Hi, {{ Auth::user()->name }}!</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" 
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endauth

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
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
</body>
</html>

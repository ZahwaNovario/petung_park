<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>Admin</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            margin-right: 10px;
        }

        .custom-navbar {
            --bs-navbar-color: rgba(255, 255, 255, .85) !important;
            --bs-navbar-hover-color: rgba(255, 255, 255) !important;
            background-color: #295A3F;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1;
        }

        .navbar .dropdown-menu {
            background-color: #295A3F !important;
            border: none;
        }

        .navbar .dropdown-menu .dropdown-item {
            color: white !important;
        }

        .navbar .dropdown-menu .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .header-padding {
            padding-top: 72px;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark custom-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin.index') }}">
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
                            <a class="nav-link" href="{{ route('generic.index') }}">Generic</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="wisataDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Wisata
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="wisataDropdown">
                                <li><a class="dropdown-item" href="{{ route('wisata.index') }}">Wisata</a></li>
                                <li><a class="dropdown-item" href="{{ route('wisata.galeri.index') }}">Wisata Galeri</a></li>
                            </ul>
                        </li>
                        @if (Auth::check() && Auth::user()->position === 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staf.index') }}">Akun</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="artikelDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Artikel
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="artikelDropdown">
                                <li><a class="dropdown-item" href="{{ route('artikel.index') }}">Artikel</a></li>
                                <li><a class="dropdown-item" href="{{ route('artikel.galeri.index') }}">Artikel Galeri</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('agenda.index') }}">Agenda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="galeriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Galeri
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="galeriDropdown">
                                <li><a class="dropdown-item" href="{{ route('galeri.index') }}">Galeri</a></li>
                                <li><a class="dropdown-item" href="{{ route('galeri.show.index') }}">Tampilan Beranda Galeri</a></li>
                                <li><a class="dropdown-item" href="{{ route('galeri.slider.index') }}">Home Slider</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Menu
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                                <li><a class="dropdown-item" href="{{ route('menu.index') }}">Hidangan & Paket</a></li>
                                <li><a class="dropdown-item" href="{{ route('menu.menupaket.index') }}">Menu Paket</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
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
        <div class="header-padding"></div>
    </div>
</body>

</html>


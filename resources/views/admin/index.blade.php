@extends('layouts.mainAdmin')

@section('page-css')
    <style>
        body {
            background-color: #FFFBE6 !important; 
            font-family: Arial, sans-serif !important; 
        }
        @media (min-width: 992px) { 
            .btn-custom {
                margin-bottom: 8px; 
                width: 100%;      
            }
            .row-custom {
                gap: 10px; 
                justify-content: center; 
                align-items: center; 
                
            }
        }

        @media (max-width: 991px) { 
            .btn-custom {
                margin-bottom: 16px; 
            }
        }
    </style>
@endsection

@section('content')

<div class="container mt-5">
    <h1 class="text-center" style="color: #557C56;">Berikut Menu Admin</h1>

    <!-- Artikel & Kategori Section -->
    <div class="row row-custom mt-5">
        <h3 class="text-center mb-4" style="color: #295A3F;">Artikel & Kategori</h3>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('artikel.index') }}">Artikel</a>
        </div>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('artikel.galeri.index') }}">Kolase Foto Artikel</a>
        </div>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('kategori.index') }}">Kategori</a>
        </div>
    </div>

    <!-- Wisata Section -->
    <div class="row row-custom mt-5">
        <h3 class="text-center mb-4" style="color: #295A3F;">Wisata</h3>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('wisata.index') }}">Wisata</a>
        </div>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('wisata.galeri.index') }}">Kolase Foto Wisata</a>
        </div>
    </div>

    @if (Auth::check() && Auth::user()->position === 'Admin')
    <!-- Pegawai Section -->
    <div class="row row-custom mt-5">
        <h3 class="text-center mb-4" style="color: #295A3F;">Pegawai</h3>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('staf.index') }}">Akun Pegawai & Pengunjung </a>
        </div>
    </div>
    @endif

    <!-- Menu Section -->
    <div class="row row-custom mt-5">
        <h3 class="text-center mb-4" style="color: #295A3F;">Hidangan & Paket</h3>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('menu.index') }}">Hidangan/Paket</a>
        </div>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('menu.menupaket.index') }}">Kolase Menu Paket</a>
        </div>
    </div>

    <!-- Agenda & Galeri Section -->
    <div class="row row-custom mt-5">
        <h3 class="text-center mb-4" style="color: #295A3F;">Agenda & Galeri</h3>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('agenda.index') }}">Agenda</a>
        </div>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('galeri.index') }}">Galeri</a>
        </div>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('galeri.slider.index') }}">Galeri Slider</a>
        </div>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('galeri.show.index') }}">Galeri Show</a>
        </div>
    </div>

    <!-- Generic Section -->
    <div class="row row-custom mt-5">
        <h3 class="text-center mb-4" style="color: #295A3F;">Generic</h3>
        <div class="col-lg-2 col-md-4 d-flex justify-content-center">
            <a class="btn btn-warning btn-custom px-3 py-2" style="font-weight: bold;" href="{{ route('generic.index') }}">Generic</a>
        </div>
    </div>
</div>
@endsection


@extends('layouts.main')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/kategori.css') }}">
@endsection
@section('container-main')
    <!-- Kategori Makanan -->
    <div class="kategori-makanan">
        <div class="kategori-header">
            <a href="{{ route('wisata') }}" class="btn-kembali">Kembali</a>
            <h2>Kategori Kuliner</h2>
        </div>
        <div class="makanan-container">
            @forelse($kategori->menus as $menu)
                <div class="makanan">
                    <img id="reguler_{{ $menu->id }}" class="zoomimg"
                        src="{{ asset($menu->gallery->photo_link ?? '/images/footer/logoPetungPark.png') }}"
                        alt="Foto {{ $menu->name }}">
                    <p id="text_reguler_{{ $menu->id }}" class="judul-makanan">{{ $menu->name }}</p>
                    <button onclick="window.location.href='{{ url('hidangan', $menu->id) }}'">Lihat Hidangan</button>
                </div>
            @empty
                <p>Tidak ada hidangan yang tersedia untuk kategori ini.</p>
            @endforelse
        </div>
    </div>
@endsection

@include('layouts.modalimg')

@section('page-js')
    <script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection

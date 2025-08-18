@extends('layouts.main')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/paketShow.css') }}">
@endsection

@section('container-main')
    <div class="kategori-wisata">
        <!-- Kategori Header for Paket -->
        <div class="kategori-header">
            <a href="{{ route('wisata') }}" class="btn-kembali">Kembali</a>
            <h2 id="text_{{$paket->id}}">{{ $paket->name }}</h2>
        </div>

        <div class="paket-detail">
            <!-- Foto Paket diganti dengan foto gallery-->
            <div class="paket-photo">
                {{-- @foreach ($paket->menus as $menu)
                <img src="{{ asset($menu->gallery->photo_link ??  '/images/footer/logoPetungPark.png') }}" alt="Foto {{ $menu->name }}">
            @endforeach --}}
                @php
                    $photo = $paket->menus->isNotEmpty()
                        ? $paket->gallery->photo_link
                        : '/images/footer/logoPetungPark.png';
                @endphp
                <img id="{{$paket->id}}" src="{{ asset($photo) }}" class="zoomimg">
            </div>

            <!-- Harga dan Like Count -->
            <p class="text-center">Harga: Rp. {{ number_format($paket->price, 0, ',', '.') }}</p>

            <!-- Container untuk tombol like dan jumlah like -->
            <div class="like-container text-center">
                <button class="like-button" data-package-id="{{ $paket->id }}">
                    <span id="like-count"
                        class="{{ $paket->number_love % 2 === 0 ? 'even' : 'odd' }}">{{ $paket->number_love }}</span>
                    <span class="like-icon">❤️</span>
                </button>
            </div>

            <!-- Menu dalam Paket -->
            <h2 class="mt-5">Menu dalam Paket:</h2>
            <ul class="menu-list">
                @forelse($paket->menus as $menu)
                    <li>
                        <p><strong>Nama Menu:</strong> {{ $menu->name }}</p>
                        <p><strong>Deskripsi:</strong> {{ $menu->description }}</p>
                    </li>
                @empty
                    <li>Tidak ada menu dalam paket ini.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
@include('layouts.modalimg')

@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.like-button');
            likeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const likeCount = button.querySelector('#like-count');
                    let currentLikes = parseInt(likeCount.textContent);
                    const packageId = button.dataset.packageId;

                    // Send request to toggle like in the backend
                    fetch(`/paket/${packageId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            likeCount.textContent = data
                            .number_love; // Update the like count displayed on the page
                            updateLikeCountDisplay(
                            likeCount); // Update the style (odd/even class)
                        })
                        .catch(error => {
                            console.error("Error updating like:", error);
                        });
                });
            });

            // Update the like count's style based on odd/even value
            function updateLikeCountDisplay(likeCount) {
                const count = parseInt(likeCount.textContent);
                if (count % 2 === 0) {
                    likeCount.classList.remove('odd');
                    likeCount.classList.add('even');
                } else {
                    likeCount.classList.remove('even');
                    likeCount.classList.add('odd');
                }
            }
        });
    </script>
    <script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection

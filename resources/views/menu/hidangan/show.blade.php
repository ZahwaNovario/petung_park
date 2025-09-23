@extends('layouts.main')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/hidangan.css') }}">
@endsection

@section('container-main')
    <!-- Kategori Makanan -->
    <div class="kategori-makanan">
        <div class="kategori-header">
            <a href="{{ route('kategori.makanan', $menu->category->id) }}" class="btn-kembali">Kembali</a>
        </div>
        <div class="hidangan-container">
            <img id="{{$menu->id}}" src="{{ asset($menu->gallery->photo_link ?? 'https://via.placeholder.com/300x300') }}" alt="hidangan" class="zoomimg hidangan-gambar">
            <div class="hidangan-detail">
                <h3 id="text_{{$menu->id}}">{{ $menu->name }}</h3>
                <p class="desc">{{ $menu->description }}</p>
                <p class="harga">Harga: Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>
                <p class="rekomendasi">
                    @if($menu->status_recommended == 1)
                        <div class="rekomendasi-container">
                            <img src="{{ asset('/images/beranda/logo/rekomen.png') }}" alt="Rekomendasi" class="rekomendasi-logo">
                            <i>Rekomendasi</i></div>
                    @endif
                </p>
                <div class="like-container">
                    <button class="like-button" data-menu-id="{{ $menu->id }}">
                        ❤️
                    </button>
                    <span id="like-count" class="like-count {{ $menu->number_love % 2 === 0 ? 'even' : 'odd' }}">{{ $menu->number_love }}</span>
                </div>
            </div>
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
                    // Ambil elemen 'like-count' yang tepat
                    const likeCount = button.parentElement.querySelector('.like-count');
                    let currentLikes = parseInt(likeCount.textContent);
                    const menuId = button.dataset.menuId;

                    // Kirim request untuk toggle like di backend
                    fetch(`/hidangan/${menuId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        likeCount.textContent = data.number_love; // Perbarui jumlah like
                        updateLikeCountDisplay(likeCount); // Perbarui style (odd/even class)
                    })
                    .catch(error => {
                        console.error("Error updating like:", error);
                    });
                });
            });

            // Update tampilan jumlah like berdasarkan odd/even
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
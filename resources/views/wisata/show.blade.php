@extends('layouts.main')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/wisata.css') }}">
@endsection

@section('container-main')
    <div class="kategori-wisata">
        <div class="kategori-header">
            <a href="{{ route('wisata') }}" class="btn-kembali">Kembali</a>
            <h2>{{ $spot->name }}</h2>
        </div>
        <div class="wisata-container">
            <p>{{ $spot->description }}</p>
            <div class="like-container">
            <button class="like-button-travel" data-travel-id="{{ $spot->id }}">
                <span id="like-count-{{ $spot->id }}" class="{{ $spot->number_love % 2 === 0 ? 'even' : 'odd' }}">
                    {{ $spot->number_love }}
                </span>
                <span class="like-icon"> ❤️</span>
            </button>
            </div>
            <br>
        </div>

        <!-- Galeri -->
        <div class="galeri-container">
            <div class="galeri-grid">
                @forelse($galleries as $gallery)
                    <div class="galeri-item">
                        <img id="alam_{{ $gallery->id }}" class="zoomimg" src="{{ $gallery->photo_link }}"
                            alt="{{ $gallery->name }}">
                        <p>{{ $gallery->name }}</p>
                        <p id="text_alam_{{ $gallery->id }}">{{ $gallery->description }}</p>
                        <div class="like-container">
                            <button class="like-button" data-gallery-id="{{ $gallery->id }}">
                                <span id="like-count-{{$gallery->id}}"
                                    class="{{ $gallery->number_love % 2 === 0 ? 'even' : 'odd' }}">{{ $gallery->number_love }}</span>
                                <span class="like-icon">❤️</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <p style="color: white;">Tidak ada gambar yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
@include('layouts.modalimg')

@section('page-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function handleGalleryLike() {
            const likeButtons = document.querySelectorAll('.like-button');
            likeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const galleryId = button.dataset.galleryId;
                    const likeCount = document.getElementById(`like-count-${galleryId}`);
                    
                    fetch(`/galeri/${galleryId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error(data.error);
                            return;
                        }
                        // Update like count and toggle classes
                        likeCount.textContent = data.number_love;
                        updateLikeCountDisplay(likeCount);
                    })
                    .catch(error => {
                        console.error("Error updating gallery like:", error);
                    });
                });
            });
        }

        function handleTravelLike() {
            const likeButtonsTravel = document.querySelectorAll('.like-button-travel');
            likeButtonsTravel.forEach(button => {
                button.addEventListener('click', function () {
                    const travelId = button.dataset.travelId;
                    const likeCount = document.getElementById(`like-count-${travelId}`);
                    
                    fetch(`/wisata/${travelId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error(data.error);
                            return;
                        }
                        // Update like count and toggle classes
                        likeCount.textContent = data.number_love;
                        updateLikeCountDisplay(likeCount);
                    })
                    .catch(error => {
                        console.error("Error updating travel like:", error);
                    });
                });
            });
        }

        // Helper function to toggle odd/even classes
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

        // Initialize like handlers
        handleGalleryLike();
        handleTravelLike();
    });
</script>
<script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection


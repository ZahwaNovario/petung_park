@extends('layouts.main')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/kegiatan.css') }}">
@endsection

@section('container-main')
<div class="kegiatan-detail">
    <a href="{{ url()->previous() }}" class="btn-kembali">Kembali</a>
    <h2>{{ $agenda->event_name }}</h2>

    <div class="kegiatan-info">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($agenda->event_start_date)->format('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($agenda->event_end_date)->format('d/m/Y') }}</p>
        <p><strong>Lokasi:</strong> {{ $agenda->event_location }}</p>
        <p><strong>Deskripsi:</strong></p>
        <p style="text-align: justify;">{{ $agenda->description }}</p>
    </div>

    <div class="gallery">
        @foreach ($galleries as $gallery)
        <div class="gallery-item">
            <img id="{{ $gallery->id }}" src="{{ asset($gallery->photo_link) }}" alt="{{ $gallery->name }}" class="gallery-img zoomimg">
            <p id="text_{{ $gallery->id }}">{{ $gallery->description }}</p>

            <div class="like-container">
                <button class="like-button" data-gallery-id="{{ $gallery->id }}">
                    <span id="like-count-{{ $gallery->id }}" class="{{ $gallery->number_love % 2 === 0 ? 'even' : 'odd' }}">
                        {{ $gallery->number_love }}
                    </span>
                    <span class="like-icon">❤️</span>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <div class="artikel">
        @if ($articles->isEmpty())
        <p style="text-align: center;">Tidak ada artikel terkait.</p>
        @else
        @foreach ($articles as $article)
        <div class="article">
            <p>{{ $article->main_content }}</p>
        </div>
        <div class="like-container">
            <button class="like-button-article" data-article-id="{{ $article->id }}">
                <span id="like-count-{{ $article->id }}" class="{{ $article->number_love % 2 === 0 ? 'even' : 'odd' }}">
                    {{ $article->number_love }}
                </span>
                <span class="like-icon"> ❤️</span>
            </button>
        </div>
        @endforeach
        @endif
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

        // Function to handle like for articles
        function handleArticleLike() {
            const likeButtonsArticle = document.querySelectorAll('.like-button-article');
            likeButtonsArticle.forEach(button => {
                button.addEventListener('click', function () {
                    const articleId = button.dataset.articleId;
                    const likeCount = document.getElementById(`like-count-${articleId}`);
                    
                    fetch(`/artikel/${articleId}/like`, {
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
                        console.error("Error updating article like:", error);
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
        handleArticleLike();
    });
</script>
<script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection

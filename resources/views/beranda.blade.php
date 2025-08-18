@extends('layouts.main')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/beranda.css') }}">
@endsection

@section('container-main')
    <section>
        <div class="slider-container">
            <div class="slider">
                @foreach ($sliderHomes as $slide)
                    @if ($slide->gallery->photo_link)
                        <div class="slide" style="background-image: url('{{ asset($slide->gallery->photo_link) }}')">
                            <h1 class="title text">{{ $slide->gallery->name }}</h1>
                            <p class="description text">{{ $slide->gallery->description }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="navigation">
                <button class="nav-button" id="prevBtn">❮</button>
                <button class="nav-button" id="nextBtn">❯</button>
            </div>
        </div>
    </section>

    <!-- Bagian Video -->
    <section class="m-5">
        <div class="con-video">
            <iframe class="video-frame" src="{{ $info['video_promosi'] }}" title="YouTube Video Player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </section>

    <!-- Bagian Sejarah -->
    <section class="bg-success text-white text-center py-5">
        <div class="container">
            <h2 class="title-beranda">SEJARAH</h2>
            <p class="desc-beranda mt-4">{{ $info['sejarah'] }}
            </p>
        </div>
    </section>

    <!-- Bagian Lokasi -->
    <section class="bg-location text-dark text-center py-5">
        <div class="container">
            <h2 class="title-beranda">LOKASI</h2>
            <div class="row justify-content-center mt-5">
                <div class="col">
                    <iframe src="{{ $info['peta_lokasi'] }}" width="500" height="400" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        class="img-lokasi"></iframe>
                </div>
                <div class="col">
                    <div class="desc-beranda text-start">
                        <p>{{ $info['alamat'] }}</p>
                        <div class="row align-items-end">
                            <p>
                                <img src="{{ asset($info['telepon_logo']) }}" alt="Logo Telepon" class="whatsapp-logo">
                                <b> Telepon</b> : {{ $info['telepon'] }}
                                <br />
                                <img src="{{ asset($info['jam_logo']) }}" alt="Logo Jam" class="jam-logo">
                                <b> Jam</b> : {{ $info['jam'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bagian Galeri -->
    <section class="bg-custom text-white text-center py-5">
        <div class="container">
            <h2 class="title-beranda">GALERI</h2>
            <div class="row justify-content-center mt-4">
            @foreach ($galleryShows as $galleryShow)
                @if ($galleryShow->gallery) <!-- Check if the gallery is not null -->
                    <div class="col-md-4 overflow-hidden">
                        <div class="frame-image">
                            @if ($galleryShow->gallery && $galleryShow->gallery->photo_link)
                                <img id="{{ $galleryShow->id }}" src="{{ asset($galleryShow->gallery->photo_link) }}"
                                    alt="{{ $galleryShow->name }}" class="galeri-image zoomimg">
                            @else
                                <p class="text-center">Tidak ada foto</p>
                            @endif
                            <div class="content-container">
                                <p id="text_{{ $galleryShow->id }}" class="text-image">{{ $galleryShow->name }}</p>
                                <p class="desc-image">{{ $galleryShow->description }}</p>
                                <button class="like-button" data-gallery-id="{{ $galleryShow->gallery->id ?? '' }}">
                                    <span id="like-count"
                                        class="{{ $galleryShow->gallery->number_love % 2 === 0 ? 'even' : 'odd' }}">{{ $galleryShow->gallery->number_love ?? 0 }}</span>
                                    <span class="like-icon">❤️</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            </div>
        </div>
    </section>
@endsection
@include('layouts.modalimg')
@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const likeButtons = document.querySelectorAll('.like-button');
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentIndex = 0;

        function updateSliderPosition() {
            const offset = -currentIndex * 100; // Calculate offset based on currentIndex
            slider.style.transform = `translateX(${offset}%)`; // Apply the transformation
        }

        nextBtn.addEventListener('click', function() {
            currentIndex = (currentIndex + 1) % slides.length; // Move to the next slide
            updateSliderPosition();
        });

        prevBtn.addEventListener('click', function() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length; // Move to the previous slide
            updateSliderPosition();
        });

        updateSliderPosition();

        const autoSlideInterval = 3000; // Change slide every 3 seconds
        let autoSlideTimer = setInterval(() => {
            currentIndex = (currentIndex + 1) % slides.length; // Move to the next slide
            updateSliderPosition();
        }, autoSlideInterval);

        document.querySelector('.slider-container').addEventListener('mouseover', () => {
            clearInterval(autoSlideTimer); // Stop auto-slide
        });

        document.querySelector('.slider-container').addEventListener('mouseout', () => {
            autoSlideTimer = setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length; // Resume auto-slide
                updateSliderPosition();
            }, autoSlideInterval);
        });

        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const likeCount = button.querySelector('#like-count');
                const galleryId = button.dataset.galleryId;

                fetch(`/galeri/${galleryId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        likeCount.textContent = data.number_love;
                        // showAlert(data.action === 'liked' ? 'You liked this gallery!' : 'You unliked this gallery.');
                        // alert(data.action === 'liked' ? 'Anda menyukai foto ini!' : 'Anda batal menyukai foto ini.');

                    })
                    .catch(error => {
                        console.error("Error updating like:", error);
                        alert('Terjadi kesalahan saat mengupdate like Anda. Silakan coba lagi.', true);
                    });
            });
        });
    });

    </script>
    <script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection

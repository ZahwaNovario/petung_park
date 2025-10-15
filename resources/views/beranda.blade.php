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
    <!-- Section Reservasi -->

    <!-- <section class="position-relative text-white py-5"
                                            {{-- style="background: url('{{ asset('images/galeri/pemandangan/gazeboKecek.JPG') }}') center/cover no-repeat;"> --}}
                                            <div class="overlay position-absolute w-100 h-100" style="top:0; left:0; background: rgba(41,90,63,0.7);"></div>

                                            <div class="container position-relative">
                                                <h2 class="title-beranda text-center mb-5 text-warning">Reservasi</h2>

                                                <div class="row justify-content-center">
                                                    <div class="col-lg-8">
                                                        <div class="card shadow-lg border-0 rounded-3 text-center p-5" style="background:#fff; color:#295A3F;">
                                                            <h3 class="fw-bold mb-3">Pesan Spot Favoritmu 🎯</h3>
                                                            <p class="mb-4" style="font-size: 15px;">
                                                                Dapatkan pengalaman terbaik dengan melakukan reservasi meja atau spot pilihan Anda terlebih
                                                                dahulu.
                                                            </p>

                                                            {{-- @guest
                            <a href="{{ route('login') }}" class="btn btn-lg btn-success px-5 py-3 shadow-sm rounded-pill">
                                Login untuk Reservasi
                            </a>
                        @else
                            @if (!auth()->user()->hasVerifiedEmail())
                                <button id="btn-reservasi" class="btn btn-lg btn-secondary px-5 py-3 shadow-sm rounded-pill">
                                    Reservasi Sekarang
                                </button>
                            @else
                                <a id="btn-reservasi"
                                    class="btn btn-lg btn-warning text-white px-5 py-3 shadow-sm rounded-pill">
                                    Reservasi Sekarang
                                </a>
                            @endif
                        @endguest --}}
                                                            <button id="btn-reservasi" class="btn btn-success">
                                                                Reservasi Sekarang
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section> -->

    <!-- Section Virtual Tour -->
    <section id="virtual-tour" class="py-5" style="background-color:#88d28e; color:#2e7d32;">
        <div class="container d-flex flex-column flex-md-row align-items-center">
            <!-- LEFT SIDE -->
            <div class="col-md-5 text-md-start text-center mb-4 mb-md-0">
                <h2 class="fw-bold mb-3">Virtual Tour</h2>
                <p class="mb-4">
                    Jelajahi keindahan Petung Park secara interaktif melalui tampilan 360°.
                    Nikmati sensasi berkeliling tanpa batas hanya dari layar Anda.
                </p>
                @if ($firstLocation && $firstLocation->scenes->isNotEmpty())
                    <a href="{{ route('scene.show') }}" class="btn btn-success px-4 py-2">See More</a>
                @endif
            </div>

            <!-- RIGHT SIDE (CAROUSEL) -->
            <div class="col-md-7">
                <div id="vtCarousel" class="carousel caro-slide" data-bs-ride="carousel" data-bs-interval="10000"
                    style="background-color:#000000;">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#vtCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#vtCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#vtCarousel" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#vtCarousel" data-bs-slide-to="3"></button>
                    </div>

                    <div class="carousel-inner rounded-4 overflow-hidden shadow-lg">
                        <div class="carousel-item active">
                            <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover rounded-4">
                                <source src="/videos/gubuk_kecek.mp4" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Gubuk Kecek</h5>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover rounded-4">
                                <source src="/videos/resto_kafe.mp4" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Resto Kafe</h5>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover rounded-4">
                                <source src="/videos/panggung_atas.mp4" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Panggung Panorama</h5>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover rounded-4">
                                <source src="/videos/pasar_preng.mp4" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Pasar Preng Sewu</h5>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#vtCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#vtCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
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
                    @if ($galleryShow->gallery)
                        <!-- Check if the gallery is not null -->
                        <div class="col-md-4 overflow-hidden">
                            <div class="frame-image">
                                @if ($galleryShow->gallery && $galleryShow->gallery->photo_link)
                                    <img id="{{ $galleryShow->id }}"
                                        src="{{ asset($galleryShow->gallery->photo_link) }}"
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


@section('page-js')
    {{-- <script>
        document.getElementById('btn-reservasi').addEventListener('click', function() {
            @guest
            // belum login
            Swal.fire({
                icon: 'info',
                title: 'Login Dulu',
                text: 'Silakan login untuk melakukan reservasi.',
                confirmButtonText: 'Login',
                confirmButtonColor: '#295A3F',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        @else
            @if (!auth()->user()->hasVerifiedEmail())
                // sudah login tapi belum verifikasi email
                Swal.fire({
                    icon: 'warning',
                    title: 'Verifikasi Diperlukan',
                    text: 'Silakan verifikasi email terlebih dahulu sebelum reservasi.',
                    confirmButtonText: 'Verifikasi Sekarang',
                    showCancelButton: true,
                    cancelButtonText: 'Nanti Saja',
                    confirmButtonColor: '#295A3F',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // arahkan ke halaman verify.blade.php
                        window.location.href = "{{ route('verification.notice') }}";
                    }
                });
            @else
                // sudah login & email terverifikasi → lanjut reservasi
                window.location.href = "{{ route('reservasi.index') }}";
            @endif
        @endguest
        });
    </script> --}}
    {{-- @include('layouts.modalimg') --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.querySelector('.slider');
            const slides = document.querySelectorAll('.slide');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            let currentIndex = 0;
            let autoSlideTimer = null;
            const autoSlideInterval = 4000; // 4 detik biar halus

            function updateSliderPosition() {
                const offset = -currentIndex * 100;
                slider.style.transform = `translateX(${offset}%)`;
            }

            function startAutoSlide() {
                stopAutoSlide(); // <-- penting, biar gak dobel interval
                autoSlideTimer = setInterval(() => {
                    currentIndex = (currentIndex + 1) % slides.length;
                    updateSliderPosition();
                }, autoSlideInterval);
            }

            function stopAutoSlide() {
                if (autoSlideTimer) clearInterval(autoSlideTimer);
            }

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSliderPosition();
                startAutoSlide(); // reset timer biar gak langsung skip
            });

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateSliderPosition();
                startAutoSlide();
            });

            // Pause saat mouse hover
            const container = document.querySelector('.slider-container');
            container.addEventListener('mouseenter', stopAutoSlide);
            container.addEventListener('mouseleave', startAutoSlide);

            // Jalankan otomatis saat pertama kali load
            updateSliderPosition();
            startAutoSlide();
        });
    </script>
    <script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection

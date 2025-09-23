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
    <section class="bg-dark text-white py-5">
        <div class="container">
            <h2 class="title-beranda text-center mb-5 text-warning">Virtual Tour</h2>

            <div id="tour-container">
                <div id="viewer-area">
                    <div id="pano"></div>
                    <div id="caption"></div>
                </div>
            </div>



            {{-- JSON data untuk JS --}}
            <script id="scene-data" type="application/json">
            {!! json_encode([
                'activeSceneId' => optional($scenes->first())->id,

                'scenes' => $scenes->map(function ($s) {
                    return [
                        'id'          => $s->id,
                        'name'        => $s->name,
                        'caption'     => "Ini adalah {$s->name}.",
                        'imagePath'   => asset($s->image_path),
                        'locationSlug'=> optional($s->location)->slug,

                        'hotspots'    => $s->connections->map(function ($c) {
                            return [
                                'yaw'         => $c->yaw,
                                'pitch'       => $c->pitch,
                                'targetScene' => optional($c->sceneTo)->id,   // atau ->slug
                            ];
                        })->values(),
                    ];
                })->values(),
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
            </script>


            <div class="text-center mt-3">
                <a href="{{ route('scene.show', 1) }}" class="btn btn-warning">Show More</a>
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
                currentIndex = (currentIndex - 1 + slides.length) % slides
                    .length; // Move to the previous slide
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
                            alert('Terjadi kesalahan saat mengupdate like Anda. Silakan coba lagi.',
                                true);
                        });
                });
            });
        });
    </script>
    <script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection

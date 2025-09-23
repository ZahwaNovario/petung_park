@extends('layouts.main')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/hidangan.css') }}">
@endsection

@section('container-main')
    @php
        $liked = auth()->check() && $menu->likes->contains(auth()->id());
        $likeCount = $menu->likes->count();
    @endphp

    <div class="kategori-makanan">
        <div class="kategori-header">
            <a href="{{ route('kategori.makanan', $menu->category->id) }}" class="btn-kembali">Kembali</a>
        </div>

        <div class="hidangan-container">
            <img id="img-{{ $menu->id }}"
                src="{{ asset($menu->gallery->photo_link ?? 'https://via.placeholder.com/300x300') }}" alt="hidangan"
                class="zoomimg hidangan-gambar">

            <div class="hidangan-detail">
                <h3 id="text_{{ $menu->id }}">{{ $menu->name }}</h3>

                <p class="desc">{{ $menu->description }}</p>

                <p class="harga">
                    Harga:
                    @if ($menu->price == 0)
                        -
                    @else
                        Rp. {{ number_format($menu->price, 0, ',', '.') }}
                    @endif
                </p>

                @if ($menu->status_recommended == 1)
                    <div class="rekomendasi-container">
                        <img src="{{ asset('/images/beranda/logo/rekomen.png') }}" alt="Rekomendasi"
                            class="rekomendasi-logo">
                        <i>Rekomendasi</i>
                    </div>
                @endif

                <div class="like-container">
                    <button type="button" class="like-button {{ $liked ? 'liked' : '' }}"
                        data-menu-id="{{ $menu->id }}" data-liked="{{ $liked ? '1' : '0' }}"
                        aria-label="Suka menu ini">
                        <span class="like-icon">{{ $liked ? '♥' : '♡' }}</span>
                    </button>
                    <span id="like-count-{{ $menu->id }}" class="like-count">{{ $likeCount }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.modalimg')

@section('page-js')
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Hindari binding ganda
            document.querySelectorAll('.like-button').forEach(btn => {
                if (btn.dataset.bound === '1') return; // sudah di-bind
                btn.dataset.bound = '1';

                btn.addEventListener('click', async () => {
                    const menuId = btn.dataset.menuId;
                    const countEl = document.getElementById(`like-count-${menuId}`);

                    try {
                        const res = await fetch(`/hidangan/${menuId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json', // << penting: paksa 401 JSON, bukan redirect
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            credentials: 'same-origin' // bawa cookie sesi
                        });

                        // Jika route masih di-group auth, Laravel bisa redirect (302) ke /login.
                        // Tangani agar tidak lanjut parsing JSON.
                        if (res.redirected || (res.url && res.url.includes('/login'))) {
                            showLoginOnce();
                            return;
                        }

                        if (!res.ok) {
                            if (res.status === 401) {
                                showLoginOnce();
                            }
                            return;
                        }

                        const data = await res.json();

                        // Update angka
                        if (countEl && typeof data.number_love !== 'undefined') {
                            countEl.textContent = data.number_love;
                        }

                        // Toggle ikon ♥ / ♡
                        const icon = btn.querySelector('.like-icon');
                        if (data.status === 'liked') {
                            btn.classList.add('liked');
                            btn.dataset.liked = '1';
                            if (icon) icon.textContent = '♥';
                        } else {
                            btn.classList.remove('liked');
                            btn.dataset.liked = '0';
                            if (icon) icon.textContent = '♡';
                        }
                    } catch (e) {
                        console.error('Like error:', e);
                    }
                });
            });

            let loginAlertShown = false;

            function showLoginOnce() {
                if (loginAlertShown) return;
                loginAlertShown = true;
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Diperlukan',
                    text: 'Silakan login dulu untuk menyukai menu ini.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    loginAlertShown = false;
                });
            }
        });
    </script>

    <script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection

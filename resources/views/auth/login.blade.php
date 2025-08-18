@extends('layouts.loginRegis')
@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    @endsection

@section('container-main')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Login Form Section -->
            <div class="col-md-12 d-flex align-items-center justify-content-center">
                <div class="login-container">
                    <div class="login-title">Masuk</div>
                    <form id="login-form" class="inputLogin" method="POST" action="{{ route('login_process') }}"> 
                        @csrf 
                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label justify-content-start">{{ __('Alamat Email') }}</label>
                            <div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                            </div>
                        </div>
                        @error('email')
                            <div class="error-message col-md-8 offset-md-2">
                                <span class="text-danger" style="font-size: 14px;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror

                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label justify-content-start">{{ __('Kata Sandi') }}</label>
                            <div>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Kata Sandi" name="password" required autocomplete="current-password" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                            </div>
                        </div>
                        @error('password')
                            <div class="error-message col-md-8 offset-md-2">
                                <span class="text-danger" style="font-size: 14px;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror

                    <!-- "Remember Me" and "Forgot Your Password?" -->
                    <div class="form-group remember-me-container">
                        <div class="form-check">
                            <input class="form-check-input custom-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Ingat Saya') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-password-link" href="{{ route('password.request') }}">
                                {{ __('Lupa kata sandi?') }}
                            </a>
                        @endif
                    </div>


                        <!-- Button Login -->
                    <div class="col-md-8 offset-md-2">
                        <button type="submit" class="btn btn-block">
                            {{ __('Masuk') }}
                        </button>
                    </div>

                    <!-- Signup Section -->
                    <div class="signup-container">
                        <p class="text-regis">Belum memiliki akun ?</p>
                        <button type="button" style="font-weight: bold" class="btn p-0 ml-2" onclick="window.location.href='{{ route('register') }}'">{{ __('Daftar') }}</button>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            setTimeout(() => {
                // Create a fixed overlay to prevent body shift
                const overlay = document.createElement('div');
                overlay.style.position = 'fixed';
                overlay.style.top = 0;
                overlay.style.left = 0;
                overlay.style.width = '100vw';
                overlay.style.height = '100vh';
                overlay.style.backgroundColor = 'rgba(0,0,0,0.3)';
                overlay.style.zIndex = '9998';  // Set overlay z-index lower than SweetAlert
                document.body.appendChild(overlay);

                // Show SweetAlert
                Swal.fire({
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    backdrop: false, // Disable the default backdrop
                    didOpen: () => {
                        document.body.style.overflow = 'hidden'; // Prevent scroll on body
                    },
                    willClose: () => {
                        document.body.style.overflow = ''; // Restore body scroll
                        document.body.removeChild(overlay); // Remove the overlay when closed
                    },
                    customClass: {
                        popup: 'swal-popup-custom' // Custom class for SweetAlert to handle z-index
                    }
                });
            }, 500); // Slight delay to prevent layout shift
        @endif
    });

    $(document).ready(function() {
        $('#login-form').submit(function(e) {
            e.preventDefault();
            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
                type: 'POST',
                url: '/login-process',
                data: {
                    email: email,
                    password: password,
                    '_token': '{{ csrf_token() }}',
                    'expectsJson': true
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success alert
                        $('body').prepend(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 80%; max-width: 400px; display: block;">
                                <strong>Login Berhasil!</strong> Anda akan dialihkan ke beranda...
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);

                        setTimeout(function() {
                            window.location.href = "{{ route('beranda') }}";
                        }, 2000); // Redirect after 2 seconds
                    } else {
                        alert(response.message); // Display error alert
                    }
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan saat login. Periksa kembali email dan kata sandi Anda.");
                }
            });
        });
    });
</script>
@endsection

@extends('layouts.app')
@extends('layouts.loginRegis')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
@endsection
@section('container-main')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Register Form Section -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="login-container">
                    <div class="login-title">Daftar</div>

                    <form class="inputRegister">
                        <div class="form-group">
                            <input type="text" class="form-control p-3" placeholder="Masukkan Nama Pengguna" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control p-3" placeholder="Masukkan Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control p-3" placeholder="Masukkan Kata Sandi" required>
                        </div>
                        <button type="submit" class="btn btn-block" onclick="window.location.href='{{ url('beranda') }}'">Daftar</button>
                    </form>

                    <!-- Signup Section -->
                    <div class="signup-container d-flex align-items-center mt-4">
                        <p class="mb-0">Sudah memiliki akun?</p>
                        <button type="button" class="btn p-0 ml-2" onclick="window.location.href='{{ url('login') }}'">Masuk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@extends('layouts.loginRegis')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex align-items-center justify-content-center">
            <div class="login-container">
                <div class="login-title">Daftar</div>
                    <form action="{{ route('register_process') }}" method="POST" class="inputRegister" >
                        @csrf

                        <div class="row mb-3 form-group">
                            <div class="col-md-12">
                                <label for="name" class="col-form-label">{{ __('Nama') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama Pengguna" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email" class="col-form-label">{{ __('Alamat Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="password" class="col-form-label">{{ __('Kata Sandi') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Kata Sandi" name="password" required autocomplete="new-password" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group">
                                <label for="passwordConfirm">{{ __('Konfirmasi Kata Sandi') }}</label>
                                <input type="password" class="form-control" id="passwordConfirm" name="password_confirmation" placeholder="Masukkan Kembali Kata Sandi" required autocomplete="password" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                            </div>
                        

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="dob" class="col-form-label">Tanggal Lahir</label>
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" value="2000-01-01" placeholder="Masukkan Tanggal Lahir" name="dob" required autocomplete="dob">

                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="gender" class="col-form-label">Jenis Kelamin</label>
                                <select id="gender" name="gender" class="gender-select form-control">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="phone" class="col-form-label">Nomor Telepon</label>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" placeholder="081234567890" pattern="[0-9]{10,15}" name="phone" required autocomplete="phone" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Daftar') }}
                                </button>
                            </div>
                        </div>

                        <div class="signup-container d-flex align-items-center mt-4">
                            <p class="mb-0" style="font-size: 18px;">Sudah memiliki akun?</p>
                            <a class="btn btn-link p-0 ml-2 mb-3" style="color: #295A3F; font-size: 20px;" onclick="window.location.href='{{ route('login') }}'">{{ __('Masuk') }}</a>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection

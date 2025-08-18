@extends('layouts.loginRegis')
@extends('layouts.app')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
@endsection

@section('container-main')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Login Form Section -->
            <div class="col-md-12 d-flex align-items-center justify-content-center"> <!-- Mengubah kolom menjadi 12 untuk full width -->
            <div class="login-container">
                    <div class="login-title">Masuk</div>

                    <form class="inputLogin" method="POST" action="{{ route('login') }}"> 
                        @csrf 
                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="form-group col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Kata Sandi" name="password" required autocomplete="current-password">
                            </div>
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 offset-md-3 d-flex align-items-center">
                            <input class="form-check-input custom-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 mb-0 d-flex align-items-center" style="font-size: 14px;" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-block">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                    </form>
                    <!-- Signup Section -->
                    <div class="signup-container">
                        <button type="button" class="btn p-0 ml-2" onclick="window.location.href='{{ route('register') }}'">{{ __('Register') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.loginRegis')
@extends('layouts.app')

@section('title', 'Verifikasi Email')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}">
@endsection

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="col-md-8">
                {{-- @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                    </div>
                @endif --}}
                <div class="card">
                    <div class="card-header">{{ __('Verifikasi Alamat Email Anda') }}</div>

                    <div class="card-body">
                        {{ __('Sebelum melanjutkan, harap periksa email Anda untuk tautan verifikasi.') }}
                        {{ __('Jika Anda tidak menerima email tersebut') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk meminta yang lain') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        @if (session('message'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('message')),
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                showCloseButton: true
            });
        @endif
    </script>
@endsection

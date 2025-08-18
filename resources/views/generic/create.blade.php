@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/kegiatanAdd.css') }}">
@endsection
@section('content')
<body>
    <div class="container mt-5">
        <br>
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <br>
        <h1 class="text-center text-success">Tambah Generic</h1>
        <form action="{{ route('generic.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="key">Kata Kunci:</label>
                <input type="text" class="form-control" id="key" name="key" placeholder="Contoh: sosial_media_instagram" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="value">Isi:</label>
                <input type="text" class="form-control" id="value" name="value" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="photo">Gambar Ikon:</label>
                <input type="file" class="form-control" id="photo" name="photo" accept=".jpg, .jpeg, .png" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                @error('photo')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Tambahkan</button>
                <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('generic.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</body>

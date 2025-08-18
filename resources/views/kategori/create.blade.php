@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/kategoriAdd.css') }}">
@endsection

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-success">Tambah Kategori</h1>
        <form action="{{ route('kategori.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nama Kategori:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Tambahkan</button>
                <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('kategori.index') }}'">Batal</button>
            </div>
        </form>
    </div>
</body>
</html>
@endsection

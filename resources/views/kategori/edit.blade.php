@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/hidanganUpdate.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Update Kategori</h1>
        <form action="{{ route('kategori.update', $category->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">Nama Kategori:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            @if ($category->status == '0')  
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $category->status }}">
            @endif

            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('kategori.index') }}'">Kembali</button>
        </form>
    </div>
@endsection


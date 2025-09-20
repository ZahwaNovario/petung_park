@extends('layouts.mainAdmin')

@section('page-css')
<link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center" style="color: #557C56;">Daftar Lokasi</h1>
{{-- 
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    <a class="btn btn-warning mb-3 fw-bold" href="{{ route('locations.create') }}">+ Tambah Lokasi</a>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Slug</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($locations as $loc)
                <tr>
                    <td>{{ $loc->id }}</td>
                    <td>{{ $loc->name }}</td>
                    <td>{{ $loc->slug }}</td>
                    <td>
                        <a href="{{ route('locations.edit', $loc->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('locations.destroy', $loc->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Menghapus lokasi ini akan menghapus semua scene terkait. Yakin?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

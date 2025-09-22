@extends('layouts.mainAdmin')

@section('page-css')
<link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center" style="color:#557C56;">Daftar Scene</h1>

    <a class="btn btn-warning mb-3 fw-bold" href="{{ route('scenes.create') }}">+ Tambah Scene</a>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Lokasi</th>
                <th>Preview</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scenes as $scene)
                <tr>
                    <td>{{ $scene->id }}</td>
                    <td>{{ $scene->name }}</td>
                    <td>{{ $scene->location->name ?? '-' }}</td>
                    <td class="text-center">
                        @if($scene->image_path)
                            <img src="{{ asset($scene->image_path) }}"
                                 alt="preview"
                                 class="img-thumbnail"
                                 style="max-width: 120px;">
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('scenes.edit', $scene->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('scenes.destroy', $scene->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Menghapus scene ini akan menghapus semua koneksi terkait. Yakin?')">
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

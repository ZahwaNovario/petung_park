@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Daftar Lokasi</h1>
        {{--
    @if (session('success'))
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
                @foreach ($locations as $loc)
                    <tr>
                        <td>{{ $loc->id }}</td>
                        <td>{{ $loc->name }}</td>
                        <td>{{ $loc->slug }}</td>
                        <td>
                            <a href="{{ route('locations.edit', $loc->id) }}" class="btn btn-primary">Edit</a>

                            
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal-{{ $loc->id }}">
                                Delete
                            </button>

                            <div class="modal fade" id="deleteModal-{{ $loc->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel-{{ $loc->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel-{{ $loc->id }}">Konfirmasi
                                                Hapus Lokasi</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <p>Yakin ingin menghapus lokasi <strong>{{ $loc->name }}</strong>?</p>
                                            <p class="text-danger mb-0"><small>Menghapus lokasi ini juga akan menghapus
                                                    semua scene dan file virtual tour di dalamnya.</small></p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>

                                            <form action="{{ route('locations.destroy', $loc->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

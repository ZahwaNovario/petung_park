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
                @foreach ($scenes as $scene)
                    <tr>
                        <td>{{ $scene->id }}</td>
                        <td>{{ $scene->name }}</td>
                        <td>{{ $scene->location->name ?? '-' }}</td>
                        <td class="text-center">
                            @if ($scene->image_path)
                                <img src="{{ asset($scene->image_path) }}" alt="preview" class="img-thumbnail"
                                    style="max-width: 120px;">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('scenes.edit', $scene->id) }}" class="btn btn-primary">Edit</a>

                            
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal-{{ $scene->id }}">
                                Delete
                            </button>

                            <div class="modal fade" id="deleteModal-{{ $scene->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel-{{ $scene->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel-{{ $scene->id }}">Hapus Scene
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body text-dark">
                                            <p>
                                                Yakin ingin menghapus scene
                                                <strong class="text-danger">{{ $scene->name }}</strong>?
                                            </p>
                                            <p class="mb-0">
                                                <small class="text-muted">Tindakan ini juga akan menghapus semua koneksi
                                                    terkait.</small>
                                            </p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Batal
                                            </button>

                                            <form action="{{ route('scenes.destroy', $scene->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                </button>
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

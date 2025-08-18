@php
    $hasNonActive = $categories->contains(fn($category) => !$category->menus()->exists());
@endphp
@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section('content')

    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Kategori</h1>

        <!-- Tabel Kategori -->
        <a class="btn btn-warning mb-3" style="font-weight: bold;" onclick="location.href='{{ route('kategori.create') }}'">Tambah Kategori</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    @if ($hasNonActive)
                        <th>Nonaktif</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->status ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>
                            <button class="btn btn-primary" onclick="location.href='{{ route('kategori.edit', $category->id) }}'">Perbarui</button>
                        </td>
                        @if ($hasNonActive && !$category->menus()->exists()) 
                            <td>    
                                <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $category->id }}, {{ (int)$category->status }})">
                                    Nonaktif
                                </button>

                                <div class="modal fade" id="nonaktifModal-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="nonaktifModalLabel-{{ $category->id }}">Konfirmasi Nonaktif</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="modalMessage-{{ $category->id }}">
                                                Apakah Anda yakin ingin mengubah status kategori ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('kategori.unactive', $category->id) }}" method="POST" id="nonaktifForm-{{ $category->id }}">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('page-js')
<script src="{{ asset('js/modalHandler.js') }}"></script>
<script>
    function handleNonaktif(categoryId, status) {
        var modalMessage = document.getElementById('modalMessage-' + categoryId);
        var nonaktifForm = document.getElementById('nonaktifForm-' + categoryId);

        if (status === 0) {
            modalMessage.innerHTML = "Kategori ini sudah nonaktif.";
            nonaktifForm.querySelector("button[type='submit']").disabled = true;
        } else {
            modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
            nonaktifForm.querySelector("button[type='submit']").disabled = false;
        }

        $('#nonaktifModal-' + categoryId).modal('show');
    }

    $(document).ready(function() {
        @if(session('success'))
            $('#BerhasilModal').modal('show');
            $('#BerhasilModal .modal-body').html('Data berhasil dinonaktifkan');
        @endif
    });
</script>
@endsection

@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/galeri.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Galeri Show</h1>
        <a href="{{ route('galeri.show.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah Foto</a>

        <table class="table table-bordered">
            <thead class="thead-dark" style="background-color: #557C56; color: #FFFBE6;">
                <tr>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    <th>Nonaktif</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($shows as $show)
                <tr>
                    <td>{{ $show->name }}</td>
                    <td><img src="{{ asset($show->gallery->photo_link) }}" alt="Foto Galeri" style="max-width: 100px;"></td>
                    <td>{{ $show->status == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $show->created_at }}</td>
                    <td>{{ $show->updated_at }}</td>
                    <td>
                        <a href="{{ route('galeri.show.edit', ['gallery' => $show]) }}" class="btn btn-primary">Perbarui</a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $show->id }}, {{ $show->status }})">
                            Nonaktif
                        </button>

                        <div class="modal fade" id="nonaktifModal-{{ $show->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $show->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="nonaktifModalLabel-{{ $show->id }}">Konfirmasi Nonaktif</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modalMessage-{{ $show->id }}">
                                        Apakah Anda yakin ingin mengubah status data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('galeri.show.unactive', $show->id) }}" method="POST" id="nonaktifForm-{{ $show->id }}">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger">Nonaktifkan</button>
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

@section('page-js')
    <script>
        function handleNonaktif(galleryId, status) {
            var modalMessage = document.getElementById('modalMessage-' + galleryId);
            var nonaktifForm = document.getElementById('nonaktifForm-' + galleryId);
            
            if (status === 0) {
                modalMessage.innerHTML = "Galeri ini sudah nonaktif.";
                nonaktifForm.querySelector("button[type='submit']").disabled = true;
            } else {
                modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
                nonaktifForm.querySelector("button[type='submit']").disabled = false;
            }

            $('#nonaktifModal-' + galleryId).modal('show');
        }

        $(document).ready(function() {
            @if(session('success'))
                $('#BerhasilModal').modal('show');
            @endif
        });
    </script>
@endsection


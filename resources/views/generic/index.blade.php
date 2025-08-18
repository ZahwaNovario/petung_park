@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/galeri.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Generic</h1>
        <a href="{{ route('generic.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah Data Generic</a>

        <table class="table table-bordered">
            <thead class="thead-dark" style="background-color: #557C56; color: #FFFBE6;">
                <tr>
                    <th>Kata Kunci</th>
                    <th>Foto</th>
                    <th>Isi</th>
                    <th>Status</th>
                    <th>Nama Staff</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    <!-- <th>Nonaktif</th> -->
                </tr>
            </thead>
            <tbody>
            @foreach ($generics as $generic)
                <tr>
                    <td>{{ $generic->key }}</td> 
                    <td>
                        @if ($generic-> icon_picture_link != null)
                            <img src="{{ asset($generic->icon_picture_link) }}" alt="Foto 1" style="max-width: 100px;">
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                    <td>{{ $generic->value }}</td>
                    <td>{{ $generic->status == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $generic->user ? $generic->user->name : 'Tidak ada User yang Bertanggung Jawab' }}</td>
                    <td>{{ $generic->created_at }}</td>
                    <td>{{ $generic->updated_at }}</td>
                    <td>
                        <a href="{{ route('generic.edit', ['generic' => $generic]) }}" class="btn btn-primary">Perbarui</a>
                    </td>
                    <!-- <td>
                        <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $generic->id }}, {{ $generic->status }})">
                            Nonaktif
                        </button>

                        <div class="modal fade" id="nonaktifModal-{{ $generic->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $generic->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="nonaktifModalLabel-{{ $generic->id }}">Konfirmasi Nonaktif</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modalMessage-{{ $generic->id }}">
                                        Apakah Anda yakin ingin mengubah status data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('generic.unactive', $generic->id) }}" method="POST" id="nonaktifForm-{{ $generic->id }}">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td> -->
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('page-js')
    <script>
        function handleNonaktif(genericId, status) {
            var modalMessage = document.getElementById('modalMessage-' + genericId);
            var nonaktifForm = document.getElementById('nonaktifForm-' + genericId);
            
            if (status === 0) {
                modalMessage.innerHTML = "Data generic ini sudah nonaktif.";
                nonaktifForm.querySelector("button[type='submit']").disabled = true; // Disable the submit button
            } else {
                modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
                nonaktifForm.querySelector("button[type='submit']").disabled = false; // Enable the submit button
            }

            $('#nonaktifModal-' + genericId).modal('show');
        }

        $(document).ready(function() {
            @if(session('success'))
                $('#BerhasilModal').modal('show');
            @endif
        });
    </script>
@endsection

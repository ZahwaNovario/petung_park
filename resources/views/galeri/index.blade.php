@extends('layouts.mainAdmin')
@php
    $hasNonActive = $galleries->contains(fn($galeri) => 
        !$galeri->articles()->exists() &&
        !$galeri->travels()->exists() &&
        !$galeri->menu()->exists() &&
        !$galeri->packages()->exists() &&
        !$galeri->users()->exists() &&
        !$galeri->slidersHome()->exists() && 
        !$galeri->galleriesShow()->exists() 
    );
@endphp
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/galeri.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Galeri</h1>
        <a href="{{ route('galeri.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah Foto</a>

        <table class="table table-bordered">
            <thead class="thead-dark" style="background-color: #557C56; color: #FFFBE6;">
                <tr>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Banyak Like</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    @if($hasNonActive)
                    <th>Nonaktif</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach ($galleries as $galeri)
                <tr>
                    <td>{{ $galeri->name }}</td>
                    <td><img src="{{ asset($galeri->photo_link) }}" alt="Foto Galeri 1" style="max-width: 100px;"></td>
                    <td>{{ $galeri->description }}</td>
                    <td>{{ $galeri->status == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $galeri->number_love }}</td>
                    <td>{{ $galeri->created_at }}</td>
                    <td>{{ $galeri->updated_at }}</td>
                    <td>
                        <a href="{{ route('galeri.edit', ['gallery' => $galeri]) }}" class="btn btn-primary">Perbarui</a>
                    </td>
                    @if($hasNonActive)
                        @if (!$galeri->menu()->exists() && 
                            !$galeri->articles()->exists() && 
                            !$galeri->travels()->exists() && 
                            !$galeri->slidersHome()->exists() && 
                            !$galeri->galleriesShow()->exists() && 
                            !$galeri->users()->exists() && 
                            !$galeri->packages()->exists())
                            <td>
                            <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $galeri->id }}, {{ $galeri->status }})">
                                Nonaktif
                            </button>
                            <div class="modal fade" id="nonaktifModal-{{ $galeri->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $galeri->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="nonaktifModalLabel-{{ $galeri->id }}">Konfirmasi Nonaktif</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="modalMessage-{{ $galeri->id }}">
                                            Apakah Anda yakin ingin mengubah status data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('galeri.unactive', $galeri->id) }}" method="POST" id="nonaktifForm-{{ $galeri->id }}">
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
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('page-js')
    <script>
        // Function to handle the nonaktif process
        function handleNonaktif(galleryId, status) {
            var modalMessage = document.getElementById('modalMessage-' + galleryId);
            var nonaktifForm = document.getElementById('nonaktifForm-' + galleryId);
            
            if (status === 0) {
                // If the gallery is already nonaktif, show a custom message in the modal and prevent form submission
                modalMessage.innerHTML = "Galeri ini sudah nonaktif.";
                nonaktifForm.querySelector("button[type='submit']").disabled = true; // Disable the submit button
            } else {
                // If the gallery is active, proceed to the normal nonaktif process
                modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
                nonaktifForm.querySelector("button[type='submit']").disabled = false; // Enable the submit button
            }

            // Show the modal
            $('#nonaktifModal-' + galleryId).modal('show');
        }

        $(document).ready(function() {
            @if(session('success'))
                $('#BerhasilModal').modal('show');
            @endif
        });
    </script>
@endsection

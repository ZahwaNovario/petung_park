@php
    $hasNonActive = $staffs->contains(fn($pegawai) => 
        !$pegawai->articles()->exists() &&
        !$pegawai->generics()->exists() &&
        !$pegawai->menus()->exists() &&
        !$pegawai->agendas()->exists()
    );
@endphp
@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/staffShow.css') }}">
@endsection
@section('content')
<div class="container-fluid mt-5">
    <h1 class="text-center" style="color: #557C56;">Tabel Pegawai</h1>
    <a href="{{ route('staf.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah Pegawai</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark" style="background-color: #557C56; color: #FFFBE6;">
                <tr>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Tgl Lahir</th>
                    <th>No. Telp</th>
                    <th>Posisi</th>
                    <th>J. Kelamin</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Perbarui</th>
                    @if($hasNonActive)
                    <th>Nonaktif</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($staffs as $pegawai)
                    <tr>
                        <td>{{ $pegawai->email }}</td>
                        <td>{{ $pegawai->name }}</td>
                        <td>
                            @if (isset($pegawai->gallery) && $pegawai->gallery->photo_link !== null)
                                <img src="{{ asset($pegawai->gallery->photo_link) }}" alt="Foto" style="max-width: 100px;">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td>{{ $pegawai->date_of_birth }}</td>
                        <td>{{ $pegawai->phone_number }}</td>
                        <td>{{ $pegawai->position }}</td>
                        <td>{{ $pegawai->gender }}</td>
                        <td>{{ $pegawai->status ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>{{ $pegawai->created_at }}</td>
                        <td>{{ $pegawai->updated_at }}</td>
                        <td>
                            <a href="{{ route('staf.edit', ['user' => $pegawai->id]) }}" class="btn btn-primary mb-1">Perbarui</a>
                        </td>
                        @if($hasNonActive)
                            @if (!$pegawai->articles()->exists() &&
                         !$pegawai->generics()->exists() &&
                          !$pegawai->menus()->exists() &&
                           !$pegawai->agendas()->exists())
                        <td> 
                            <button type="button" 
                                        class="btn btn-danger"  
                                        onclick="handleNonaktif({{ $pegawai->id }}, {{ $pegawai->status }})">
                                    Nonaktif
                            </button>
                            <div class="modal fade" id="nonaktifModal-{{ $pegawai->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $pegawai->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="nonaktifModalLabel-{{ $pegawai->id }}">Konfirmasi Nonaktif</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="modalMessage-{{ $pegawai->id }}">Apakah Anda yakin ingin mengubah status data ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('staf.unactive', ['user' => $pegawai->id]) }}" method="POST" id="nonaktifForm-{{ $pegawai->id }}">
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
</div>
@endsection
@section('page-js')
<script>
    function handleNonaktif(userId, status) {
        var modalMessage = document.getElementById('modalMessage-' + userId);
        var nonaktifForm = document.getElementById('nonaktifForm-' + userId);

        if (status === 0) {
            modalMessage.innerHTML = "Staff ini sudah nonaktif.";
            nonaktifForm.querySelector("button[type='submit']").disabled = true;
        } else {
            modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
            nonaktifForm.querySelector("button[type='submit']").disabled = false;
        }

        $('#nonaktifModal-' + userId).modal('show');
    }
</script>
@endsection

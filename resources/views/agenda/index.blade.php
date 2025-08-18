@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/kegiatanStaff.css') }}">
@endsection

@section('content')
@php
    $hasNonActive = $agendas->contains(fn($agenda) => !$agenda->articles()->exists());
@endphp
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Agenda</h1>
        <a href="{{ route('agenda.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah Agenda</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>User</th>
                    <th>Perbarui</th>
                    @if ($hasNonActive)
                        <th>Nonaktif</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($agendas as $agenda)
                    <tr>
                        <td>{{ $agenda->event_name }}</td>
                        <td>{{ $agenda->event_start_date }}</td>
                        <td>{{ $agenda->event_end_date }}</td>
                        <td>{{ $agenda->event_location }}</td>
                        <td>{{ $agenda->status ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>{{ $agenda->description }}</td>
                        <td>{{ $agenda->created_at }}</td>
                        <td>{{ $agenda->updated_at }}</td>
                        <td>{{ $agenda->user ? $agenda->user->name : 'Tidak ada User yang Bertanggung Jawab' }}</td>
                        <td>
                            <button class="btn btn-primary" onclick="location.href='{{ route('agenda.edit', $agenda->id)}}'">Perbarui</button>
                        </td>
                        @if ($hasNonActive)
                            @if (!$agenda->articles()->exists()) 
                        <td> 
                            <button type="button" 
                                        class="btn btn-danger"  
                                        onclick="handleNonaktif({{ $agenda->id }}, {{ $agenda->status }})">
                                    Nonaktif
                            </button>
                       
                            <div class="modal fade" id="nonaktifModal-{{ $agenda->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $agenda->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="nonaktifModalLabel-{{ $agenda->id }}">Konfirmasi Nonaktif</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="modalMessage-{{ $agenda->id }}">Apakah Anda yakin ingin mengubah status data ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('agenda.unactive', ['agenda' => $agenda->id]) }}" method="POST" id="nonaktifForm-{{ $agenda->id }}">
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
       function handleNonaktif(agendaId, status) {
        var modalMessage = document.getElementById('modalMessage-' + agendaId);
        var nonaktifForm = document.getElementById('nonaktifForm-' + agendaId);

        if (modalMessage && nonaktifForm) {
            if (status === 0) {
                modalMessage.innerHTML = "Jadwal agenda ini sudah nonaktif.";
                nonaktifForm.querySelector("button[type='submit']").disabled = true; // Disable the submit button
            } else {
                modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
                nonaktifForm.querySelector("button[type='submit']").disabled = false; // Enable the submit button
            }
            $('#nonaktifModal-' + agendaId).modal('show'); // Show the modal
        } else {
            console.error("Modal or form elements are missing for agenda ID:", agendaId);
        }
    }

    $(document).ready(function () {
        @if(session('success'))
            $('#BerhasilModal').modal('show');
        @endif
    });
    </script>
@endsection

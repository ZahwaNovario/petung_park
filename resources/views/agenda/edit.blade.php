@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/kegiatanUpdate.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Update Agenda</h1>
        <form action="{{ route('agenda.update', $agenda->id) }}" method="post">
            @csrf 
            <div class="form-group">
                <label for="name">Nama Agenda:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $agenda->event_name }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $agenda->event_start_date }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="end_date">Tanggal Selesai:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $agenda->event_end_date }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="location">Lokasi:</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ $agenda->event_location }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>
            
            @if ($agenda->status == '0')
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $agenda->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $agenda->status == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $agenda->status }}">
            @endif

            <div class="form-group">
                <label for="desc">Deskripsi:</label>
                <textarea class="form-control" id="desc" name="desc" rows="4">{{ $agenda->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="" disabled {{ is_null($agenda->user_id) ? 'selected' : '' }}>Pilih Staff Yang Bertanggung Jawab</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $agenda->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('agenda.index') }}'">Batal</button>
            </div>
        </form>
    </div>
@endsection


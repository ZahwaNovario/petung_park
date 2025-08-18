@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataUpdate.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="judul">Update Artikel</h1>
        <form action="{{ route('artikel.update', ['artikel' => $artikel->id]) }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="title">Judul:</label>
                <textarea class="form-control" id="title" name="title" rows="4" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">{{ $artikel->title }}</textarea>
            </div>

            <div class="form-group">
                <label for="main_content">Konten:</label>
                <textarea class="form-control" id="main_content" name="main_content" style="min-height: 300px;" rows="4" required>{{ $artikel->main_content }}</textarea>
            </div>
            @if ($artikel->status == '0')
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $artikel->status == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $artikel->status == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $artikel->status }}">
            @endif
            <div class="form-group">
                <label for="agenda_id"> Pilih Kegiatan :</label>
                <select class="form-control" id="agenda_id" name="agenda_id">
                    <option value="" disabled {{ !$artikel || !$artikel->agenda ? 'selected' : '' }}>Pilih Kegiatan</option>
                    @foreach($agendas as $agenda)
                        <option value="{{ $agenda->id }}" {{ $artikel && $artikel->agenda && $artikel->agenda->id == $agenda->id ? 'selected' : '' }}>
                            {{ $agenda->event_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="" disabled {{ is_null($artikel->user_id) ? 'selected' : '' }}>Pilih Staff Yang Bertanggung Jawab</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $artikel->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('artikel.index') }}'">Kembali</button>
        </form>
    </div>
@endsection


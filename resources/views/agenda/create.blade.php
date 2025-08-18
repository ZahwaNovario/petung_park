@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/kegiatanAdd.css') }}">
@endsection
@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Tambah Agenda</h1>
        <form action="{{ route('agenda.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama Agenda:</label>
                <input type="text" class="form-control" id="name" name="name" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="end_date">Tanggal Selesai:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="location">Lokasi:</label>
                <input type="text" class="form-control" id="location" name="location" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="desc">Deskripsi:</label>
                <textarea class="form-control" id="desc" name="desc" rows="4" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')"></textarea>
            </div>

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            
            <div class="text-center">
                <button type="submit" class="btn btn-success">Tambahkan</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('agenda.index') }}'">Batal</button>
            </div>
        </form>
    </div>
@endsection
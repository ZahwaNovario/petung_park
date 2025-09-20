@extends('layouts.mainAdmin')

@section('page-css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        .pano-box {
            width: 100%;
            height: 400px;
            background: #111;
            border-radius: 8px;
            overflow: hidden;
        }

        .preview-container {
            margin-top: 2rem;
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="form-container">
        <h1>Tambah Scene</h1>
        <form method="POST" action="{{ route('scenes.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Lokasi</label>
                <select name="location_id" required>
                    @foreach ($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Scene</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Upload Gambar 360</label>
                <!-- tambahin name supaya bisa masuk ke request -->
                <input type="file" id="fileInput" name="image" accept="image/*" required>
            </div>

            <!-- hidden input untuk nyimpen connections -->
            <input type="hidden" name="connections" id="connectionsInput">

            <button type="submit" class="btn btn-success">Simpan Scene</button>
        </form>

    </div>

    <div class="preview-container">
        <h3>Preview 360</h3>
        <div id="pano" class="pano-box"></div>

        <!-- Tombol tambah koneksi -->
        <button id="addConnectionBtn" class="btn btn-primary" style="margin-top:15px;">
            + Add Connection
        </button>

        <!-- Panel list koneksi sementara -->
        <div id="connectionsPanel" style="margin-top:20px; text-align:left;">
            <h4 style="margin-bottom:10px;">Connections</h4>
            <ul id="connectionList" style="list-style:none; padding:0; font-size:14px; color:#444;"></ul>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        window.allScenes = @json($scenes);
    </script>
@endsection

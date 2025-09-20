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
        <h1>Edit Scene</h1>
        <form method="POST" action="{{ route('scenes.update', $scene->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Lokasi</label>
                <select name="location_id" required>
                    @foreach ($locations as $loc)
                        <option value="{{ $loc->id }}" {{ $scene->location_id == $loc->id ? 'selected' : '' }}>
                            {{ $loc->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Nama Scene</label>
                <input type="text" name="name" value="{{ $scene->name }}" required>
            </div>

            <div class="form-group">
                <label>Upload Gambar 360 (opsional)</label>
                <input type="file" id="fileInput" name="image" accept="image/*">
                <p style="font-size:12px; color:#555;">Kosongkan jika tidak ingin ganti gambar.</p>
            </div>

            <button type="submit" class="btn btn-success">Update Scene</button>
            <input type="hidden" name="connections" id="connectionsInput" value="">

        </form>
    </div>

    <div class="preview-container">
        <h3>Preview 360</h3>
        <div id="pano" class="pano-box"></div>

        <!-- Tombol tambah koneksi -->
        <button id="addConnectionBtn" class="btn btn-primary" style="margin-top:15px;">
            + Add Connection
        </button>

        <!-- Panel list koneksi -->
        <div id="connectionsPanel" style="margin-top:20px; text-align:left;">
            <h4 style="margin-bottom:10px;">Connections</h4>
            <ul id="connectionList" style="list-style:none; padding:0; font-size:14px; color:#444;"></ul>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        // data lama
        window.currentScene = @json($scene);
        window.allScenes = @json($allScenes);
        window.existingConnections = @json(
            $connections->map(function ($c) {
                return [
                    'yaw' => $c->yaw,
                    'pitch' => $c->pitch,
                    'target' => (string) $c->scene_to, // pastikan string
                ];
            });
    </script>
    <!-- @vite(['resources/js/app.js']) -->
@endsection

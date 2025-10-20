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

        /* 🔹 Overlay Loading Upload */
        #upload-loading {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            text-align: center;
        }

        .upload-spinner {
            border: 6px solid rgba(255, 255, 255, 0.3);
            border-top: 6px solid #4fc3f7;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin-bottom: 12px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="form-container">
        <h1>Edit Scene</h1>
        <form method="POST" action="{{ route('scenes.update', $scene->id) }}" enctype="multipart/form-data" id="sceneForm">
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

    <!-- 🔹 Overlay Loading Upload -->
    <div id="upload-loading">
        <div class="upload-spinner"></div>
        <p>Uploading & Processing your 360° image...</p>
    </div>
@endsection

@section('page-js')
    <script>
        window.currentScene = @json($scene);
        window.allScenes = @json($allScenes);
        window.existingConnections = @json($existingConnections ?? []);

        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("sceneForm");
            const loadingOverlay = document.getElementById("upload-loading");

            if (form) {
                form.addEventListener("submit", () => {
                    // munculkan overlay
                    loadingOverlay.style.display = "flex";
                });
            }
        });
    </script>
    {{--
    <script src="{{ asset('js/preview.js') }}" defer></script>
    <!-- @vite(['resources/js/app.js']) --> --}}
@endsection

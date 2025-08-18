@extends('layouts.mainAdmin')
@section('content')
<body>
    <div class="container mt-5">
        <h1 class="text-center text-success">Perbarui Galeri</h1>
        
        <!-- Display validation errors as alert -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('galeri.update', ['gallery' => $gallery->id]) }}" method="post" enctype="multipart/form-data">
            @csrf 
            
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $gallery->name) }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                <!-- @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror -->
            </div>

            <div class="form-group">
                <label for="old_photo">Foto Saat Ini:</label>
                <div class="col-md-4">
                    <img src="{{ asset($gallery->photo_link) }}" id="old_photo" name = "old_photo" alt="Foto sebelumnya" style="max-width: 100px;">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-8">
                <label for="file">Upload Foto Baru:</label>
                    <input type="file" class="form-control-file" id="file" name="file" accept=".jpg, .jpeg, .png">
                    <!-- @error('file')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror -->
                </div>
            </div>
          
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description', $gallery->description) }}</textarea>
                <!-- @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror -->
            </div>

            @if ($gallery->status == 0)
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ old('status', $gallery->status) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $gallery->status) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <!-- @error('status')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror -->
            </div>
            @else
                <input type="hidden" name="status" value="{{ old('status', $gallery->status) }}">
            @endif

            <button type="submit" class="btn btn-success">Perbarui</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('galeri.index') }}'">Batal</button>
        </form>
    </div>
</body>
@endsection
@section('page-js')
@endsection
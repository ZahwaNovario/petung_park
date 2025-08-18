@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/kegiatanUpdate.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Update Data Generic</h1>
        <form action="{{ route('generic.update',['generic' => $generic->id]) }}" method="post" enctype="multipart/form-data">
        @csrf 

            <div class="form-group">
                <label for="key">Kata Kunci:</label>
                <input type="text" class="form-control" id="key" name="key" value="{{ old('key', $generic->key) }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                @error('key')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Display Current Photo --}}
            <div class="form-group">
                <label for="old_photo">Foto Saat Ini:</label>
                <div class="col-md-4">
                    <img src="{{ asset($generic->icon_picture_link) }}" id="old_photo" alt="Foto sebelumnya" style="max-width: 100px;">
                </div>
            </div>

            {{-- Upload New Photo with Preview --}}
            <div class="form-group">
                <div class="col-md-8">
                    <label for="photo">Upload Ikon Baru:</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept=".jpg, .jpeg, .png" onchange="previewImage(event)">
                    @error('photo')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- New Photo Preview --}}
            <div class="form-group">
                <label for="new_photo_preview">Pratinjau Foto Baru:</label>
                <div class="col-md-4">
                    <img id="new_photo_preview" src="#" alt="Pratinjau gambar" style="max-width: 100px; display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="value">Isi:</label>
                <textarea class="form-control" id="value" name="value" rows="4" required>{{ old('value', $generic->value) }}</textarea>
                @error('value')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="" disabled {{ is_null($generic->user_id) ? 'selected' : '' }}>Pilih Staff Yang Bertanggung Jawab</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $generic->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ old('status', $generic->status) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $generic->status) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div> -->

            <button type="submit" class="btn btn-success">Perbarui</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('generic.index') }}'">Batal</button>
        </form>
    </div>

    {{-- JavaScript for Image Preview --}}
    <script>
        function previewImage(event) {
            var input = event.target;
            var preview = document.getElementById('new_photo_preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show preview image
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none'; // Hide if no file selected
            }
        }
    </script>
@endsection

@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/hidanganUpdate.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Update Hidangan</h1>
        <form action="{{ route('menu.hidangan.update', $menu->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">Nama Hidangan:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $menu->name }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea class="form-control" id="description" name="description" rows="4" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">{{ $menu->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Harga:</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $menu->price }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>
            @if ($menu->status == '0')
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $menu->status == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $menu->status == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $menu->status }}">
            @endif

            <div class="form-group">
                <label for="recommendation">Rekomendasi:</label>
                <select class="form-control" id="recommendation" name="recommendation">
                    <option value="1" {{ $menu->status_recommended == '1' ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ $menu->status_recommended == '0' ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="" {{ is_null($menu->user_id) ? 'selected' : '' }}>Pilih Staff Yang Bertanggung Jawab</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $menu->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="old_photo">Foto Saat Ini:</label>
                <div class="col-md-4">
                    <img src="{{ asset($menu->gallery->photo_link) }}" id="old_photo" alt="Foto sebelumnya" style="max-width: 100px;">
                    <br>
                    <label for="old_photo_name" style="margin-right: 10px;">{{ $menu->gallery->name }}</label>
                </div>
            </div>
            <div class="form-group">
                <label for="gallery_id">Foto Baru:</label>
                <select class="form-control" id="gallery_id" name="gallery_id" required>
                    @foreach($galleries as $gallery)
                        <option value="{{ $gallery->id }}" data-img-src="{{ asset($gallery->photo_link)}}" {{ $menu->gallery_id == $gallery->id ? 'selected' : '' }}>
                            {{ $gallery->name }}
                        </option>
                    @endforeach
                </select>
                <br>
                <div id="preview-new-photo" class="text-left">
                </div>
            </div>
            <div class="form-group">
                <label for="category_id">Kategori:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('menu.index') }}'">Kembali</button>
        </form>
    </div>
@endsection
@section('page-js')
<script>
    // Event Listener for Dropdown
    document.getElementById('gallery_id').addEventListener('change', function() {
        var previewContainer = document.getElementById('preview-new-photo');
        previewContainer.innerHTML = ''; // Clear previous images
        var selectedOption = this.options[this.selectedIndex]; // Get selected option

        // Check for data-img-src and show preview
        var imgSrc = selectedOption.getAttribute('data-img-src');
        if (imgSrc) {
            var imgElement = document.createElement('img');
            imgElement.src = imgSrc;
            imgElement.style.maxWidth = '100px';
            imgElement.style.margin = '5px';
            previewContainer.appendChild(imgElement);
        }
    });
</script>
@endsection



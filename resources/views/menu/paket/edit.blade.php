@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/paketAdd.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Update Paket</h1>
        <form action="{{ route('menu.paket.update', $package->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">Nama Paket:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $package->name }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="price">Harga:</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $package->price }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>
            @if ($package->status == '0')
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $package->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $package->status ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $package->status }}">
            @endif

            <div class="form-group">
                <label for="old_photos">Foto Paket Saat Ini:</label>
                <div class="col-md-4 d-flex align-items-center justify-content-center" style="flex-wrap: wrap;">
                    <div style="margin: 10px; display: flex; align-items: center;">
                        <label for="old_photo_name" style="margin-right: 10px;">{{ $package->name }}</label>
                        <img src="{{ asset($package->gallery->photo_link) }}" id="old_photo" alt="Foto sebelumnya" style="max-width: 100px; margin-left: 10px;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Foto Baru:</label>
                <select class="form-control" id="photo" name="photo">
                    <option value="" disabled selected>Pilih Foto</option>
                    @foreach($galleries as $gallery)
                        @if($gallery->id !== $package->gallery->id)
                            <option value="{{ $gallery->id }}" data-img-src="{{ asset($gallery->photo_link) }}">
                                {{ $gallery->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <br>
                <div id="preview-new-photo" class="text-center">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('menu.index') }}'">Kembali</button>
        </form>
    </div>
@endsection

@section('page-js')
<script>
    // Event Listener for Dropdown
    document.getElementById('photo').addEventListener('change', function() {
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

@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataAdd.css') }}">
@endsection
@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Tambah Wisata</h1>
        <form action="{{ route('wisata.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="photos">Foto:</label>
                <select class="form-control" id="photos" name="photos[]" multiple>
                    @foreach($galleries as $gallery)
                        <option value="{{ $gallery->id }}" data-img-src="{{ asset($gallery->photo_link) }}">
                            {{ $gallery->name }}
                        </option>
                    @endforeach
                </select>
                <br>
                <div id="preview-photos" class="text-center">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Tambahkan</button>
                <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('wisata.index') }}'">Batal</button>
            </div>
        </form>
    </div>
@endsection

@section('page-js')
<script>
    document.getElementById('photos').addEventListener('change', function() {
        var previewContainer = document.getElementById('preview-photos');
        previewContainer.innerHTML = ''; // Clear previous previews

        Array.from(this.selectedOptions).forEach(option => {
            var imgSrc = option.dataset.imgSrc;
            if (imgSrc) {
                var imgElement = document.createElement('img');
                imgElement.src = imgSrc;
                imgElement.style.maxWidth = '100px';
                imgElement.style.margin = '5px';
                previewContainer.appendChild(imgElement);
            }
        });
    });
</script>
@endsection

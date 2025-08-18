@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/paketAdd.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Tambah Tampilan Galeri</h1>
        <form action="{{ route('galeri.show.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            
            <div class="form-group">
                <label for="name">Nama Tampilan Galeri:</label>
                <input type="text" class="form-control" id="name" name="name" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="photos">Pilih Galeri:</label>

                <select class="form-control" id="photos" name="photos[]" required multiple>
                    <option value="" selected disabled>Pilih Galeri</option>
                    @foreach ($galleries as $gallery)
                        <option value="{{ $gallery->id }}" data-img-src="{{ asset($gallery->photo_link) }}">
                            {{ $gallery->name }}
                        </option>
                    @endforeach
                </select>
                <br>
                <div id="preview-photo" class="text-center">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Tambahkan</button>
                <button type="button" class="btn btn-secondary" onclick="location.href='{{route('galeri.show.index') }}'">Batal</button>
            </div>
        </form>
    </div>
@endsection
@section('page-js')
<script>

    document.getElementById('photos').addEventListener('change', function() {
        var previewContainer = document.getElementById('preview-photo');
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



@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/paketAdd.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Update Galeri Show</h1>
        <form action="{{ route('galeri.show.update', $show->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">Nama Galeri:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $show->name }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')>
            </div>
            @if ($show->status == '0')
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $show->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$show->status ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $show->status }}">
            @endif
            <div class="form-group">
                <label for="old_photos">Foto Saat Ini:</label>
                <div class="col-md-4 d-flex align-items-center justify-content-left" style="flex-wrap: wrap;">
                    <div style="margin: 10px; display: flex; align-items: center;">
                        <img src="{{ asset($show->gallery->photo_link) }}" id="old_photo" alt="Foto sebelumnya" style="max-width: 100px; margin-left: 10px;">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Foto:</label>
                <select class="form-control" id="photo" name="photo">
                    <option value="" disabled selected>Pilih Foto</option>
                    @foreach($galleries as $showOption)
                        @if($showOption->id !== $show->gallery->id)
                            <option value="{{ $showOption->id }}" data-img-src="{{ asset($showOption->photo_link) }}">
                                {{ $showOption->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <br>
                <div id="preview-new-photo" class="text-center">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('galeri.show.index') }}'">Kembali</button>
        </form>
    </div>
@endsection

@section('page-js')
<script>
    document.getElementById('photo').addEventListener('change', function() {
        var previewContainer = document.getElementById('preview-new-photo');
        previewContainer.innerHTML = ''; // Clear previous images

        // Iterate over selected options
        Array.from(this.selectedOptions).forEach(option => {
            var imgSrc = option.getAttribute('data-img-src');
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

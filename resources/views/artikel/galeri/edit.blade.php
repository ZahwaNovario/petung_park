@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataUpdate.css') }}">
@endsection
@section('content')
    <div class="container mt-5">
        <h1 class="judul">Update Galeri Artikel</h1>
        <form action="{{ route('artikel.galeri.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" name="article_id" value="{{ $selectedCollage->article_id }}">

            <input type="hidden" name="gallery_id[]" value="{{ $selectedCollage->gallery->id }}">

            @foreach($existingGallery as $foto)
                @if ($foto->gallery->id !== $selectedCollage->gallery->id) 
                    <input type="hidden" name="gallery_id[]" value="{{ $foto->gallery->id }}">
                @endif
            @endforeach
   
            <div class="form-group">
                <label for="name_collage">Nama Kolase:</label>
                <input type="text" class="form-control" id="name_collage" name="name_collage" value="{{ $selectedCollage->name_collage }}" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>
            @if ($selectedCollage->status == '0')
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $selectedCollage->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $selectedCollage->status == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $selectedCollage->status }}">
            @endif
            
            <div class="form-group">
                <label name="article_id">Nama Artikel :</label>
                <div class="col-md-4 d-flex align-items-center justify-content-left" style="flex-wrap: wrap;">
                    @if ($selectedCollage->article)
                        <div>
                            <label name="old_article_name" >
                                {{ $selectedCollage->article->title }}
                            </label>
                        </div>
                    @else
                        <p>No Article data available.</p>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label name="old_gallery_name">Nama Galeri Saat Ini :</label>
                <div class="col-md-4 d-flex align-items-center justify-content-center" style="flex-wrap: wrap;">
                    @if ($selectedCollage->gallery)
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap;">
                            <li style="margin: 10px;">
                                <label name="old_gallery_name" style="margin-right: 10px;">
                                    {{ $selectedCollage->gallery->name }}
                                </label>
                                <img src="{{ asset($selectedCollage->gallery->photo_link) }}" width="50" height="50" style="object-fit: cover;" alt="Foto Galeri">
                            </li>
                            @foreach($existingGallery as $foto)
                            <li style="margin: 10px;">
                                <label  style="margin-right: 10px;">
                                    {{ $foto->gallery->name }}
                                </label>
                                <img src="{{ asset($foto->gallery->photo_link) }}" alt="Foto" width="50" height="50" style="object-fit: cover;">
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No Gallery data available.</p>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="new_photos">Foto Baru:</label>
                <select class="form-control" id="new_photos" name="new_photos[]" multiple>
                    <option value="" disabled>Pilih Foto</option>
                    @foreach($galleries as $gallery)
                        <option value="{{ $gallery->id }}" data-img-src="{{ asset($gallery->photo_link) }}">
                            {{ $gallery->name }}
                        </option>
                    @endforeach
                </select>
                <br>
                <div id="preview-new-photo" class="text-center">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('artikel.galeri.index') }}'">Kembali</button>
        </form>
    </div>
@endsection
@section('page-js')
<script>
       document.getElementById('new_photos').addEventListener('change', function() {
            var selectedOptions = this.selectedOptions;
            var previewContainer = document.getElementById('preview-new-photo');
            previewContainer.innerHTML = ''; // Clear previous previews

            Array.from(selectedOptions).forEach(option => {
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


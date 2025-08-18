@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/paketAdd.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Tambah Paket</h1>
        <form action="{{ route('menu.paket.store') }}" method="post" enctype="multipart/form-data">
            @csrf 
            
            <div class="form-group">
                <label for="name">Nama Paket:</label>
                <input type="text" class="form-control" id="name" name="name" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="price">Harga:</label>
                <input type="number" class="form-control" id="price" name="price" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="menus">Menu:</label>
                <select class="form-control" id="menus" name="menus[]" multiple required>
                    @foreach ($menus as $menu)
                        <option value="{{$menu->id}}" data-img-src="{{ asset($menu->gallery->photo_link) }}">{{$menu->name}}</option>
                    @endforeach
                </select>
                <br>
                <div id="preview-menus" class="text-center">
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Foto:</label>
                <select class="form-control" id="photo" name="photo" required>
                    <option value="" selected disabled>Pilih Foto Paket</option>
                    @foreach($galleries as $gallery)
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
                <button type="button" class="btn btn-secondary" onclick="location.href='{{route('menu.index') }}'">Batal</button>
            </div>
        </form>
    </div>
@endsection

@section('page-js')
<script>
    document.getElementById('menus').addEventListener('change', function() {
        var previewContainer = document.getElementById('preview-menus');
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
    document.getElementById('photo').addEventListener('change', function() {
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

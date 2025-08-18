@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/paketAdd.css') }}">
@endsection
@section('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Tambah Galeri Paket Menu</h1>
        <form action="{{ route('menu.menupaket.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="package_id"> Pilih Paket :</label>
                <select class="form-control" id="package_id" name="package_id">
                    <option value="" disabled selected>Pilih Paket</option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}">
                            {{ $package->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="menus">Menu:</label>
                <select class="form-control" id="menus" name="menus[]" multiple>
                    <option value="" disabled>Pilih Menu</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}" data-img-src="{{ asset($menu->gallery->photo_link) }}">
                            {{ $menu->name }}
                        </option>
                    @endforeach
                </select>
                <br>
                <div id="preview-photos" class="text-center">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Tambahkan</button>
                <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('menu.menupaket.index') }}'">Batal</button>
            </div>
        </form>
    </div>
@endsection

@section('page-js')
<script>
    document.getElementById('menus').addEventListener('change', function() {
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

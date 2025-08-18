@extends('layouts.mainAdmin')
@section('content')
    <div class="container mt-5">
        <h1 class="judul" style = "text-align: center;">Update Menu Paket</h1>
        <form action="{{ route('menu.menupaket.update', ['packagemenu' => $id]) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label name="current_menu_name">Menu Saat Ini :</label>
                <div class="col-md-4 align-items-center justify-content-center" style="flex-wrap: wrap;">
                    @if ($packageMenus)
                        @foreach($packageMenus as $packageMenu)
                        <input type="hidden" name="package_id" value="{{ $packageMenu->package->id }}">
                        <input type="hidden" name="menu_id[]" value="{{ $packageMenu->menu->id }}">
                            @if ($packageMenu->menu->gallery)
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <li style="margin: 10px; display: flex; align-items: center;">
                                        <img src="{{ asset($packageMenu->menu->gallery->photo_link) }}" width="50" height="50" style="object-fit: cover; margin-right: 10px;" alt="Foto Menu">
                                        <span>{{ $packageMenu->menu->name }}</span>
                                    </li>
                                </ul>
                            @else
                                <p>No gallery available for this Menu.</p>
                            @endif
                        @endforeach
                    @else
                        <p>No Package Menus available.</p>
                    @endif
                </div>
            </div>
            @if($packageMenus->first()->status == '0')
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $packageMenus->first()->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $packageMenus->first()->status == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            @else
                <input type="hidden" name="status" value="{{ $packageMenus->first()->status }}">
            @endif

            <div class="form-group">
                <label for="new_menus">Ganti Menu Baru:</label>
                <select class="form-control" id="new_menus" name="new_menus[]" multiple>
                    <option value="" disabled>Pilih Foto</option>
                    @if(!empty($menus) && is_iterable($menus))
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" data-img-src="{{ asset($menu->gallery->photo_link) }}">
                                {{ $menu->name }}
                            </option>
                        @endforeach
                    @else
                        <option disabled>Tidak ada foto tersedia</option>
                    @endif
                </select>
                <br>
                <div id="preview-new-photo" class="text-center">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('menu.menupaket.index') }}'">Kembali</button>
        </form>
    </div>
@endsection
@section('page-js')
<script>
       document.getElementById('new_menus').addEventListener('change', function() {
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


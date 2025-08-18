@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataAdd.css') }}">
@endsection
@section ('content')
    <div class="container mt-5">
        <h1 class="text-center text-success">Tambah Artikel</h1>
        <form action="{{route('artikel.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="title">Judul:</label>
                <input type="text" class="form-control" id="title" name="title" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="content">Konten:</label>
                <textarea class="form-control" id="content" name="content" required oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')"></textarea>
            </div>

            <div class="form-group">
                <label for="agenda_id"> Pilih Kegiatan :</label>
                <select class="form-control" id="agenda_id" name="agenda_id">
                    <option value="" disabled>Pilih Kegiatan</option>
                    @foreach($agendas as $agenda)
                        <option value="{{ $agenda->id }}">
                            {{ $agenda->event_name }}
                        </option>
                    @endforeach
                </select>
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
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('artikel.index') }}'">Batal</button>
            </div>
        </form>
    </div>
@endsection
@section('page-js')
<script>
    document.getElementById('photos').addEventListener('change', function() {
        var previewContainer = document.getElementById('preview-photos');
        previewContainer.innerHTML = ''; 
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


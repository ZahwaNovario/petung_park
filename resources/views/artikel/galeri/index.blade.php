@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Daftar kolase</h1>
        <a href="{{ route('artikel.galeri.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah kolase</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Kolase</th>
                    <th>Status</th>
                    <th>Judul Kolase</th>
                    <th>Gambar Gallery</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    <th>Nonaktif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collages->groupBy('article_id') as $articleId => $groupedCollages)
                    <tr>
                        <td rowspan="{{ $groupedCollages->count() }}">{{ $groupedCollages->first()->name_collage }}</td>
                        <td rowspan="{{ $groupedCollages->count() }}">
                            {{ $groupedCollages->first()->status == 1 ? 'Aktif' : 'Nonaktif' }}
                        </td>
                        <td rowspan="{{ $groupedCollages->count() }}">
                            {{ $groupedCollages->first()->article->title }}
                        </td>
                        <td>
                            @if ($groupedCollages->first()->gallery && !empty($groupedCollages->first()->gallery->photo_link))
                                <img src="{{ asset($groupedCollages->first()->gallery->photo_link) }}" alt="Foto" style="max-width: 100px;">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td rowspan="{{ $groupedCollages->count() }}">
                            {{ $groupedCollages->first()->created_at}}
                        </td>
                        <td rowspan="{{ $groupedCollages->count() }}">
                            {{ $groupedCollages->first()->updated_at}}
                        </td>
                        <td rowspan="{{ $groupedCollages->count() }}">
                            <form action="{{ route('artikel.galeri.edit') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $groupedCollages->first()->article_id }}">
                                <input type="hidden" name="gallery_id" value="{{ $groupedCollages->first()->gallery_id }}">
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </form>
                        </td>
                        <td rowspan="{{ $groupedCollages->count() }}">
                            <button type="button" 
                                    class="btn btn-danger" 
                                    onclick="handleNonaktif('{{ $groupedCollages->first()->article_id }}', '{{ $groupedCollages->first()->status }}')"
                                    data-toggle="modal" 
                                    data-target="#nonaktifModal-{{ $articleId }}">
                                Nonaktif
                            </button>
                        </td>
                    </tr>

                    @foreach($groupedCollages->skip(1) as $kolase)
                        <tr>
                            <td>
                                @if ($kolase->gallery && !empty($kolase->gallery->photo_link))
                                    <img src="{{ asset($kolase->gallery->photo_link) }}" alt="Foto" style="max-width: 100px;">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    <div class="modal fade" id="nonaktifModal-{{ $articleId }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $articleId }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="nonaktifModalLabel-{{ $articleId }}">Konfirmasi Nonaktif</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin mengubah status data ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <form action="{{ route('artikel.galeri.unactive', ['artikel' => $articleId]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('page-js')
    <script>
         function handleNonaktif(wisataId, status) {
            var modal = $('#nonaktifModal-' + wisataId);
            if (status === '0') {
                modal.find('.modal-body').text("Kolase wisata ini sudah nonaktif.");
                modal.find("button[type='submit']").prop('disabled', true);
            } else {
                modal.find('.modal-body').text("Apakah Anda yakin ingin mengubah status data ini?");
                modal.find("button[type='submit']").prop('disabled', false);
            }
            modal.modal('show');
        }

        $(document).ready(function() {
            @if(session('success'))
                $('#BerhasilModal').modal('show');
            @endif
        });
    </script>
@endsection


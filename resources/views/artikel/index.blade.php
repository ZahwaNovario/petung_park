@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section ('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Daftar Artikel</h1>
        <a href="{{ route('artikel.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah Artikel</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Judul</th>
                    <th>Konten</th>
                    <th>Status</th>
                    <th>Jumlah Like</th>
                    <th>User</th>
                    <th>Gambar</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    <th>Nonaktif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ Str::limit($article->main_content, 50) }}</td>
                    <td>{{ $article->status == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $article->number_love }}</td>
                    <td>{{ $article->user ? $article->user->name : 'Tidak ada User yang Bertanggung Jawab' }}</td>
                    <td>
                    @if ($article->galleries->isNotEmpty())
                        @foreach ($article->galleries as $image)
                            <img src="{{ asset($image->photo_link) }}" alt="Foto" style="max-width: 100px; margin-bottom : 10px">
                        @endforeach
                    @else
                        <p>Tidak ada foto</p>
                    @endif

                    </td>
                    <td>{{ $article->created_at }}</td>
                    <td>{{ $article->updated_at }}</td>
                    <td>
                        <a href="{{ route('artikel.edit', $article->id) }}" class="btn btn-primary">Perbarui</a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $article->id }}, {{ $article->status }})">
                            Nonaktif
                        </button>
                        <div class="modal fade" id="nonaktifModal-{{ $article->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $article->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="nonaktifModalLabel-{{ $article->id }}">Konfirmasi Nonaktif</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modalMessage-{{ $article->id }}">
                                        Apakah Anda yakin ingin mengubah status data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('artikel.unactive', $article->id) }}" method="POST" id="nonaktifForm-{{ $article->id }}">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('page-js')
    <script>
        function handleNonaktif(articleId, status) {
            var modalMessage = document.getElementById('modalMessage-' + articleId);
            var nonaktifForm = document.getElementById('nonaktifForm-' + articleId);
            
            if (status === 0) {
                modalMessage.innerHTML = "Artikel ini sudah nonaktif.";
                nonaktifForm.querySelector("button[type='submit']").disabled = true; // Disable the submit button
            } else {
                modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
                nonaktifForm.querySelector("button[type='submit']").disabled = false; // Enable the submit button
            }
            $('#nonaktifModal-' + articleId).modal('show');
        }

        $(document).ready(function() {
            @if(session('success'))
                $('#BerhasilModal').modal('show');
            @endif
        });
    </script>
@endsection


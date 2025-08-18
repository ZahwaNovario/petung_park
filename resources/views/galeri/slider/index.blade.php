@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/galeri.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Home Slider</h1>
        <a href="{{ route('galeri.slider.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah Foto</a>

        <table class="table table-bordered">
            <thead class="thead-dark" style="background-color: #557C56; color: #FFFBE6;">
                <tr>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    <th>Nonaktif</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($sliders as $slider)
                <tr>
                    <td>{{ $slider->name }}</td>
                    <td><img src="{{ asset($slider->gallery->photo_link) }}" alt="Foto slider 1" style="max-width: 100px;"></td>
                    <td>{{ $slider->status == 1 ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $slider->created_at }}</td>
                    <td>{{ $slider->updated_at }}</td>
                    <td>
                        <a href="{{ route('galeri.slider.edit', ['gallery' => $slider]) }}" class="btn btn-primary">Perbarui</a>
                    </td>
                    <td>
                        <!-- Button to trigger the nonaktif modal check -->
                        <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $slider->id }}, {{ $slider->status }})">
                            Nonaktif
                        </button>

                        <!-- Modal for nonaktif confirmation -->
                        <div class="modal fade" id="nonaktifModal-{{ $slider->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $slider->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="nonaktifModalLabel-{{ $slider->id }}">Konfirmasi Nonaktif</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modalMessage-{{ $slider->id }}">
                                        Apakah Anda yakin ingin mengubah status data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('galeri.slider.unactive', $slider->id) }}" method="POST" id="nonaktifForm-{{ $slider->id }}">
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
        // Function to handle the nonaktif process
        function handleNonaktif(galleryId, status) {
            var modalMessage = document.getElementById('modalMessage-' + galleryId);
            var nonaktifForm = document.getElementById('nonaktifForm-' + galleryId);
            
            if (status === 0) {
                // If the gallery is already nonaktif, show a custom message in the modal and prevent form submission
                modalMessage.innerHTML = "slider ini sudah nonaktif.";
                nonaktifForm.querySelector("button[type='submit']").disabled = true; // Disable the submit button
            } else {
                // If the gallery is active, proceed to the normal nonaktif process
                modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
                nonaktifForm.querySelector("button[type='submit']").disabled = false; // Enable the submit button
            }

            // Show the modal
            $('#nonaktifModal-' + galleryId).modal('show');
        }

        $(document).ready(function() {
            @if(session('success'))
                $('#BerhasilModal').modal('show');
            @endif
        });
    </script>
@endsection


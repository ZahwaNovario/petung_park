@extends('layouts.mainAdmin')

@section('page-css')
<link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center" style="color:#557C56;">Tambah Lokasi</h1>

    {{-- Alert inline opsional kalau mau tetap ada teksnya --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <form method="POST" action="{{ route('locations.store') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nama Lokasi</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="slug" class="form-label">Slug (opsional)</label>
                    <input type="text" id="slug" name="slug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug') }}" placeholder="Biarkan kosong untuk auto-generate">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan Lokasi</button>
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal sukses (ikuti pola halaman kategori) --}}
<div class="modal fade" id="BerhasilModal" tabindex="-1" role="dialog" aria-labelledby="BerhasilModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="BerhasilModalLabel">Berhasil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">Data berhasil disimpan</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-js')
<script>
    // Samakan pola: kalau ada session('success') tampilkan modal Berhasil
    $(document).ready(function () {
        @if(session('success'))
            $('#BerhasilModal').modal('show');
            $('#BerhasilModal .modal-body').html(@json(session('success') ?: 'Data berhasil disimpan'));
        @endif
    });
</script>
@endsection

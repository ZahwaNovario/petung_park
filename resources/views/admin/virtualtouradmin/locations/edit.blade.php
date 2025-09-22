@extends('layouts.mainAdmin')

@section('page-css')
<link rel="stylesheet" href="{{ asset('css/wisataStaff.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center" style="color:#557C56;">Edit Lokasi</h1>

    <div class="card mt-3">
        <div class="card-body">
            <form method="POST" action="{{ route('locations.update', $location->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nama Lokasi</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $location->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" id="slug" name="slug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $location->slug) }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Lokasi</button>
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

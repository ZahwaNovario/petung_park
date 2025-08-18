@extends('layouts.mainAdmin')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/staffUpdate.css') }}">
@endsection
@section('content')
    <div class="container mt-5">
        <h2 class="text-center text-success">Pembaruan Staff</h2>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staf.update', ['user' => $staff->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{ $staff->email }}" autocomplete="email" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ $staff->name }}" autocomplete="name" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="changePassword" name="changePassword" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                    <label class="form-check-label" for="changePassword">Ubah Password</label>
                </div>
                <div id="passwordFields" style="display: none;">
                    <div class="form-group">
                        <label for="oldPassword">Password Lama:</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Password Baru:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label for="newPasswordConfirm">Konfirmasi Password Baru:</label>
                        <input type="password" class="form-control" id="newPasswordConfirm" name="newPassword_confirmation" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Tanggal Lahir:</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required value="{{ $staff->date_of_birth }}" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="phone_number">Nomor Telepon:</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" required value="{{ $staff->phone_number }}" oninvalid="this.setCustomValidity('Harap isi bidang ini')" oninput="this.setCustomValidity('')">
            </div>

            <div class="form-group">
                <label for="position">Posisi:</label>
                <select class="form-control" id="position" name="position">
                    <option value="Staff" {{ $staff->position == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="User" {{ $staff->position == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="form-group">
                <label for="gender">Jenis Kelamin:</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="Laki-laki" {{ $staff->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $staff->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            @if ($staff->status == '0')
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="0"{{ $staff->status ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="1" {{ $staff->status ? 'selected' : '' }}>Aktif</option>
                    </select>
                </div>
            @else
                <input type="hidden" name="status" value="{{ $staff->status }}">
            @endif

            <div class="form-group">
                <label for="old_photo">Foto Saat Ini:</label>
                <div class="col-md-4">
                    <img src="{{ asset($staff->gallery->photo_link) }}" id="old_photo" alt="Foto sebelumnya" style="max-width: 100px;">
                </div>
                <label for="old_photo_name">{{ $staff->gallery->name }}</label>
            </div>

            <div class="form-group">
                <label for="new_photo">Foto Baru:</label>
                <select class="form-control" id="new_photo" name="new_photo">
                    <option value="" selected disabled>Pilih Foto Baru</option>
                    @foreach($galleries as $gallery)
                            <option value="{{ $gallery->id }}" data-img-src="{{ asset($gallery->photo_link) }}">
                                {{ $gallery->name }}
                            </option>
                    @endforeach
                </select>
                <br>
                <div id="preview-photo" class="text-center">
                    <img src="" style="max-width: 100px; display: none;">
                </div>
            </div>
            <button class="btn btn-success" type="submit">Simpan Perubahan</button>
            <button class="btn btn-secondary" type="button" onclick="location.href='{{ route('staf.index') }}'">Kembali</button>
        </form>
    </div>
@endsection

@section('page-js')

<script>
       document.getElementById('new_photo').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var imgSrc = selectedOption.dataset.imgSrc;
            var imgElement = document.querySelector('#preview-photo img');
            if (imgSrc) {
                imgElement.src = imgSrc;
                imgElement.style.display = 'block';
            } else {
                imgElement.style.display = 'none';
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const changePasswordCheckbox = document.getElementById('changePassword');
            const passwordFields = document.getElementById('passwordFields');
            const oldPassword = document.getElementById('oldPassword');
            const newPassword = document.getElementById('newPassword');
            const newPasswordConfirm = document.getElementById('newPasswordConfirm');

            changePasswordCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    passwordFields.style.display = 'block';
                    oldPassword.required = true;
                    newPassword.required = true;
                    newPasswordConfirm.required = true;
                } else {
                    passwordFields.style.display = 'none';
                    oldPassword.required = false;
                    newPassword.required = false;
                    newPasswordConfirm.required = false;
                }
            });
        });
    </script>
@endsection

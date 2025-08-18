@extends('layouts.mainAdmin')
@php
    $hasNonActive = $menus->contains(fn($dish) => !$dish->packages()->exists());
@endphp
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/paketAdd.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Menu</h1>

        <!-- Tabel Paket -->
        <h2 class="judul-paket" style="color: #557C56;">Paket</h2>
        <a class="btn btn-warning mb-3 font-weight-bold" onclick="location.href='{{ route('menu.paket.create') }}'">Tambah Paket</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Jumlah Like</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    <th>Nonaktif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $package)
                    <tr>
                        <td>{{ $package->name }}</td>
                        <td>Rp{{ number_format($package->price, 0, ',', '.') }}</td>
                        <td>{{ $package->status ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>{{ $package->number_love }}</td>
                        <td>{{ $package->created_at->format('d-m-Y') }}</td>
                        <td>{{ $package->updated_at->format('d-m-Y') }}</td>
                        <td>
                            <button class="btn btn-primary" onclick="location.href='{{ route('menu.paket.edit', $package->id) }}'">Perbarui</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $package->id }}, {{ (int)$package->status }},'package')">
                                Nonaktif
                            </button>

                            <div class="modal fade" id="nonaktifModal-package-{{ $package->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Nonaktif</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="modalMessage-package-{{ $package->id }}">
                                            Apakah Anda yakin ingin mengubah status paket ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('menu.paket.unactive', $package->id) }}" method="POST" id="nonaktifForm-package-{{ $package->id }}">
                                                @csrf
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

        <h2 class="hidangan-title" style="color: #557C56;">Hidangan</h2>
        <button class="btn btn-warning mb-3 font-weight-bold" onclick="location.href='{{ route('menu.hidangan.create') }}'">Tambah Hidangan</button>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Rekomendasi</th>
                    <th>Jumlah Like</th>
                    <th>User</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    @if($hasNonActive)
                        <th>Nonaktif</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $dish)
                    <tr>
                        <td>{{ $dish->name }}</td>
                        <td>Rp{{ number_format($dish->price, 0, ',', '.') }}</td>
                        <td>{{ $dish->status ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>{{ $dish->is_recommended ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $dish->number_love }}</td>
                        <td>{{ $dish->user_id ? $dish->user->name : 'Tidak Ada User yang Bertanggung Jawab' }}</td>
                        <td>{{ $dish->created_at }}</td>
                        <td>{{ $dish->updated_at }}</td>
                        <td>
                            <button class="btn btn-primary" onclick="location.href='{{ route('menu.hidangan.edit', $dish->id) }}'">Perbarui</button>
                        </td>
                        @if($hasNonActive && !$dish->packages()->exists())
                            <td>
                                <button type="button" class="btn btn-danger" onclick="handleNonaktif({{ $dish->id }}, {{ (int)$dish->status }},'menu')">
                                    Nonaktif
                                </button>

                                <div class="modal fade" id="nonaktifModal-menu-{{ $dish->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Nonaktif</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="modalMessage-menu-{{ $dish->id }}">
                                                Apakah Anda yakin ingin mengubah status hidangan ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('menu.hidangan.unactive', $dish->id) }}" method="POST" id="nonaktifForm-menu-{{ $dish->id }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('page-js')
<script src="{{ asset('js/modalHandler.js') }}"></script>
<script>
    $(document).ready(function() {
        let successMessage = "{{ session('success') }}"; // Get success message from session
        if (successMessage) {
            $('body').attr('data-success', successMessage); // Store success message in a data attribute
        }
    });
</script>
@endsection


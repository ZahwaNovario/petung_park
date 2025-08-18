@extends('layouts.mainAdmin')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/kolaseStaff.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center" style="color: #557C56;">Daftar kolase</h1>
        <a href="{{ route('menu.menupaket.create') }}" class="btn btn-warning mb-3" style="font-weight: bold;">Tambah kolase</a>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Paket</th>
                    <th>Status</th>
                    <th>Daftar Menu</th>
                    <th>Tanggal Dibuat</th>
                    <th>Tanggal Diubah</th>
                    <th>Perbarui</th>
                    <th>Nonaktif</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $displayedPackages = []; // Track displayed package IDs
                @endphp

                @foreach($packagemenus as $package)
                    @if (!in_array($package->package_id, $displayedPackages))
                        @php
                            $displayedPackages[] = $package->package_id; // Mark package_id as displayed
                        @endphp
                        <tr>
                            <td>{{ $package->package ? $package->package->name : 'Package not found' }}</td>

                            <td>{{ $package->status == 1 ? 'Aktif' : 'Nonaktif' }}</td>

                            <td>
                                @if ($package->package && $package->package->menus->isNotEmpty())
                                    @foreach($package->package->menus as $menu)
                                        {{ $menu->name }}<br>
                                    @endforeach
                                @else
                                    Tidak ada menu.
                                @endif
                            </td>

                            <td>{{ $package->created_at}}</td>

                            <td>{{ $package->updated_at}}</td>

                            {{-- Update Button --}}
                            <td>                            
                                <button class="btn btn-primary" onclick="location.href='{{ route('menu.menupaket.edit', ['packagemenu' => $package->package->id]) }}'">Perbarui</button>
                            </td>
                            <td>
                                <button type="button" 
                                        class="btn btn-danger"  
                                        onclick="handleNonaktif({{ $package->package->id }}, {{ $package->status }})">
                                    Nonaktif
                                </button>
                                <div class="modal fade" id="nonaktifModal-{{ $package->package->id }}" tabindex="-1" role="dialog" aria-labelledby="nonaktifModalLabel-{{ $package->package->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="nonaktifModalLabel-{{ $package->package->id }}">Konfirmasi Nonaktif</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="modalMessage-{{ $package->package->id }}">Apakah Anda yakin ingin mengubah status data ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('menu.menupaket.unactive', ['packagemenu' => $package->package->id]) }}" method="POST" id="nonaktifForm-{{ $package->package->id }}">
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
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('page-js')
    <script>
       function handleNonaktif(packageId, status) {
        // Ensure elements exist before manipulating them
        var modalMessage = document.getElementById('modalMessage-' + packageId);
        var nonaktifForm = document.getElementById('nonaktifForm-' + packageId);

        if (modalMessage && nonaktifForm) {
            if (status === 0) {
                modalMessage.innerHTML = "Paket ini sudah nonaktif.";
                nonaktifForm.querySelector("button[type='submit']").disabled = true; // Disable the submit button
            } else {
                modalMessage.innerHTML = "Apakah Anda yakin ingin mengubah status data ini?";
                nonaktifForm.querySelector("button[type='submit']").disabled = false; // Enable the submit button
            }
            $('#nonaktifModal-' + packageId).modal('show'); // Show the modal
        } else {
            console.error("Modal or form elements are missing for package ID:", packageId);
        }
    }

    $(document).ready(function () {
        @if(session('success'))
            $('#BerhasilModal').modal('show');
        @endif
    });
    </script>
@endsection
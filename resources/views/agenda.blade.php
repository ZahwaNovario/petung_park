@extends('layouts.main')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/agenda.css') }}">
@endsection
@section('container-main')
    <div class="kegiatan">
        <h2>Kegiatan Mendatang</h2>

        <div class="kegiatan-container">
            <div class="kegiatan-mendatang">
                <table border="0">
                    @forelse($agendaMendatang as $agenda)
                        <tr>
                            <td>Tanggal: {{ \Carbon\Carbon::parse($agenda->event_start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($agenda->event_end_date)->format('d/m/Y') }}</td>
                            <td class="judul-kegiatan-mendatang">{{ $agenda->event_name }}</td>
                            <td>{{ $agenda->event_location }}</td>
                            <td>
                                <button class="cek-kegiatan-button"
                                    onclick="window.location.href='{{ route('agenda.mendatang', $agenda->id) }}'">Cek
                                    Agenda</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada kegiatan mendatang.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
    
    <div class="kegiatan">
        <h2>Kegiatan Lalu</h2>

        <div class="kegiatan-container row g-0">
            @forelse($agendaLalu as $past)
                <div class="kegiatan-lalu col-md-9">
                    {{-- <div class="row"> --}}
                        @php
                            $galleries = $past->articles()->with('galleries')->get()->pluck('galleries')->flatten();
                            $photo = $galleries->isNotEmpty()
                                ? $galleries->first()->photo_link
                                : '/images/galeri/pemandangan/jalanHutanBambu_2.JPG';
                        @endphp
                        <div class="col-md-4">
                            <img id="lalu_{{$past->id}}" class="img-fluid zoomimg" src="{{ asset($photo) }}" alt="Icon Kegiatan Lalu">
                        </div>
                        <div class="col-md-6">
                            <div id="text_lalu_{{$past->id}}" class="judul-kegiatan-lalu">{{ $past->event_name }}</div>
                            <div class="deskripsi-kegiatan-lalu" style="margin-top: 5px;">
                                Tanggal: {{ \Carbon\Carbon::parse($past->event_start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($past->event_end_date)->format('d/m/Y') }}
                                <div class="lokasi-kegiatan-lalu" style="margin-top: 5px;">
                                    {{ $past->event_location }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button onclick="window.location.href='{{ route('agenda.lalu', $past->id) }}'">Cek
                                Agenda</button>
                        </div>
                    {{-- </div> --}}
                </div>
            @empty
                <div>Tidak ada kegiatan lalu.</div>
            @endforelse
        </div>
    </div>
@endsection

@include('layouts.modalimg')

@section('page-js')
    <script src="{{ asset('/js/imagemodal.js') }}"></script>
@endsection
@extends('layouts.main')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('/css/tentangkami.css') }}">
@endsection
@section('container-main')
    <!-- Info1 -->
    <div class="info1">
        <div class="text-info1 mt-4">
            <h2>{{$aboutUs['sejarah_nama']}}</h2>
            <p>{{$aboutUs['sejarah_text']}}</p>
                
            <p>{{$aboutUs['sejarah_2_text']}}</p>
        </div>
        <img src="{{ asset($aboutUs['gambar1']) }}" alt="Gambar Info 1" class="gambar-info1">
    </div>

    <!-- Info2 -->
    <div class="info2">
        <img src="{{ asset($aboutUs['gambar2']) }}" alt="Gambar Info 2" class="gambar-info2">
    </div>

    <!-- Info3 (gambar di kiri, teks di kanan) -->
    <div class="info3">
        <div class="text-info3">
            <h2>{{$aboutUs['visi_misi_nama']}}</h2>
            <p>{{$aboutUs['visi_misi_text']}}</p>

            <p>{{$aboutUs['visi_misi_2_text']}}</p>
        </div>
        <img src="{{ asset($aboutUs['gambar3']) }}" alt="Gambar Info 3" class="gambar-info3">
    </div>
@endsection


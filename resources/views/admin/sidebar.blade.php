<div class="p-3">
    <h2 class="text-center mb-4">Menu Admin</h2>
    <div id="accordionSidebar">
        <!-- Artikel & Kategori -->
        <div class="mb-2">
            <h6 class="d-flex justify-content-between align-items-center"
                data-toggle="collapse" data-target="#artikelCollapse"
                aria-expanded="false" aria-controls="artikelCollapse"
                style="cursor:pointer; color:#295A3F;">
                Artikel & Kategori
                <span class="ml-2">&#9662;</span>
            </h6>
            <div id="artikelCollapse" class="collapse" data-parent="#accordionSidebar">
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('artikel.index') ? 'active' : '' }}" href="{{ route('artikel.index') }}">Artikel</a>
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('artikel.galeri.index') ? 'active' : '' }}" href="{{ route('artikel.galeri.index') }}">Kolase Foto Artikel</a>
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">Kategori</a>
            </div>
        </div>

        <!-- Wisata -->
        <div class="mb-2">
            <h6 class="d-flex justify-content-between align-items-center"
                data-toggle="collapse" data-target="#wisataCollapse"
                aria-expanded="false" aria-controls="wisataCollapse"
                style="cursor:pointer; color:#295A3F;">
                Wisata
                <span class="ml-2">&#9662;</span>
            </h6>
            <div id="wisataCollapse" class="collapse" data-parent="#accordionSidebar">
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('wisata.index') ? 'active' : '' }}" href="{{ route('wisata.index') }}">Wisata</a>
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('wisata.galeri.index') ? 'active' : '' }}" href="{{ route('wisata.galeri.index') }}">Kolase Foto Wisata</a>
            </div>
        </div>

        @if (Auth::check() && Auth::user()->position === 'Admin')
        <!-- Pegawai -->
        <div class="mb-2">
            <h6 class="d-flex justify-content-between align-items-center"
                data-toggle="collapse" data-target="#pegawaiCollapse"
                aria-expanded="false" aria-controls="pegawaiCollapse"
                style="cursor:pointer; color:#295A3F;">
                Pegawai
                <span class="ml-2">&#9662;</span>
            </h6>
            <div id="pegawaiCollapse" class="collapse" data-parent="#accordionSidebar">
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('staf.index') ? 'active' : '' }}" href="{{ route('staf.index') }}">Akun Pegawai & Pengunjung</a>
            </div>
        </div>
        @endif

        <!-- Menu -->
        <div class="mb-2">
            <h6 class="d-flex justify-content-between align-items-center"
                data-toggle="collapse" data-target="#menuCollapse"
                aria-expanded="false" aria-controls="menuCollapse"
                style="cursor:pointer; color:#295A3F;">
                Hidangan & Paket
                <span class="ml-2">&#9662;</span>
            </h6>
            <div id="menuCollapse" class="collapse" data-parent="#accordionSidebar">
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('menu.index') ? 'active' : '' }}" href="{{ route('menu.index') }}">Hidangan/Paket</a>
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('menu.menupaket.index') ? 'active' : '' }}" href="{{ route('menu.menupaket.index') }}">Kolase Menu Paket</a>
            </div>
        </div>

        <!-- Agenda & Galeri -->
        <div class="mb-2">
            <h6 class="d-flex justify-content-between align-items-center"
                data-toggle="collapse" data-target="#agendaCollapse"
                aria-expanded="false" aria-controls="agendaCollapse"
                style="cursor:pointer; color:#295A3F;">
                Agenda & Galeri
                <span class="ml-2">&#9662;</span>
            </h6>
            <div id="agendaCollapse" class="collapse" data-parent="#accordionSidebar">
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('agenda.index') ? 'active' : '' }}" href="{{ route('agenda.index') }}">Agenda</a>
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('galeri.index') ? 'active' : '' }}" href="{{ route('galeri.index') }}">Galeri</a>
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('galeri.slider.index') ? 'active' : '' }}" href="{{ route('galeri.slider.index') }}">Galeri Slider</a>
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('galeri.show.index') ? 'active' : '' }}" href="{{ route('galeri.show.index') }}">Galeri Show</a>
            </div>
        </div>

        <!-- Generic -->
        <div class="mb-2">
            <h6 class="d-flex justify-content-between align-items-center"
                data-toggle="collapse" data-target="#genericCollapse"
                aria-expanded="false" aria-controls="genericCollapse"
                style="cursor:pointer; color:#295A3F;">
                Generic
                <span class="ml-2">&#9662;</span>
            </h6>
            <div id="genericCollapse" class="collapse" data-parent="#accordionSidebar">
                <a class="btn btn-warning btn-block my-1 {{ request()->routeIs('generic.index') ? 'active' : '' }}" href="{{ route('generic.index') }}">Generic</a>
            </div>
        </div>
    </div>
</div>

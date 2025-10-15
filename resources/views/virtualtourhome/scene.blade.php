    <!DOCTYPE html>
    <html>

    <head>
        <title>{{ $scene->name }} - {{ $scene->location->name }}</title>
        @vite(['resources/css/app.css', 'resources/css/tour.css', 'resources/js/app.js'])

    </head>

    <body>
        

        <!-- Tombol back -->
        <a href="{{ url('/') }}" class="back-btn">← Kembali</a>

        <div id="tour-container">
            <div id="panel">
                <h3>{{ $scene->location->name }}</h3>

                <div class="custom-select" id="custom-resolution-select">
                    <div class="select-selected">Low</div>
                    <div class="select-items select-hide">
                        <div data-value="low">Low</div>
                        <div data-value="medium">Medium</div>
                        <div data-value="original">Original</div>
                    </div>
                </div>

                <select id="resolution-select" class="resolution-select" hidden>
                    <option value="low" selected>Low</option>
                    <option value="medium">Medium</option>
                    <option value="original">Original</option>
                </select>

                @foreach ($scene->location->scenes as $s)
                    <button data-scene="{{ $s->id }}">{{ $s->name }}</button>
                @endforeach
            </div>
            <div id="viewer-area">

                <div id="loading-overlay">
                    <div class="spinner"></div>
                </div>
                <div id="pano"></div>
                <div id="caption"></div>
            </div>
        </div>



        {{-- JSON data untuk JS --}}
        <script id="scene-data" type="application/json">
    {!! json_encode([
        'activeSceneId' => $scene->id,
        'scenes' => $scene->location->scenes->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'caption' => "Ini adalah {$s->name}.",
                'imagePath' => asset($s->image_path),
                'locationSlug' => $s->location->slug,
                'hotspots' => $s->connections->map(function ($c) {
                    return [
                        'yaw' => $c->yaw,
                        'pitch' => $c->pitch,
                        'targetScene' => $c->scene_to
                    ];
                })
            ];
        })
    ]) !!}
    </script>

    </body>

    </html>

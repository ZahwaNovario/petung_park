<!DOCTYPE html>
<html>

<head>
    <title>Virtual Tour Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/css/tour.css', 'resources/js/app.js'])
</head>

<body>
    <div id="tour-container">
        <div id="panel">
            <h3>Daftar Lokasi</h3>
            <button data-scene="1">Ruang Makan</button>
            <button data-scene="2">Outdoor</button>
        </div>
        <div id="viewer-area">
            <div id="pano"></div>
            <div id="caption">Pilih lokasi dari panel di kiri untuk melihat detail.</div>
        </div>
    </div>
</body>

</html>
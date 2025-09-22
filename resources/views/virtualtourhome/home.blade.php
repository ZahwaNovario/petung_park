<!DOCTYPE html>
<html>

<head>
    <title>Virtual Tour</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite('resources/css/home.css')
</head>

<body>
    <div class="container">
        <h1>Pilih Lokasi</h1>
        <div class="location-list">
            @foreach($locations as $loc)
                <div class="location-card-wrapper">
                    <a href="{{ route('location.show', $loc->slug) }}" class="location-card">
                        <span class="location-name">{{ $loc->name }}</span>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</body>

</html>
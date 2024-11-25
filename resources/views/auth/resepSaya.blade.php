<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Saya</title>
    <link rel="stylesheet" href="{{ asset('asset/css/resepSaya.css') }}"/>
</head>
<body>
    <div class="container">
        <h1>Resep Saya</h1>

        @if(isset($error))
            <p class="error-message">{{ $error }}</p>
        @else
            @if(isset($data['data']) && count($data['data']) > 0)
                @foreach($data['data'] as $resep)
                    <div class="resep-card">
                        <img src="{{ $resep['image'] }}" alt="Gambar {{ $resep['name'] }}">
                        <div class="resep-info">
                            <p class="resep-title">{{ $resep['name'] }}</p>
                        </div>

                        <!-- Tombol Delete -->
                        <form action="{{ route('resep.delete', $resep['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p>Tidak ada resep tersedia.</p>
            @endif
        @endif
    </div>

    <!-- Tombol Home -->
    <a href="{{ route('dashboard') }}" class="home-btn">Home</a>
</body>
</html>

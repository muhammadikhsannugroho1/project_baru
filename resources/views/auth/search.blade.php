<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset ("asset/css/search.css") }}"/>
    <title>Hasil Pencarian</title>
</head>
<body>

    {{-- Tampilkan error jika ada --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <h2>Hasil Pencarian</h2>
        <div class="recipe-grid">
            @if (!empty($results) && count($results) > 0)
                @foreach ($results as $result)
                    <a href="{{ route('show', ['id' => $result->id]) }}">
                        <div class="recipe-card">
                            <div class="recipe-header">
                                <h3>{{ $result->name }}</h3>
                                <span>{{ $result->kategori ?? 'Tidak ada kategori' }}</span>
                            </div>
                            <div class="recipe-image">
                                <img src="{{ $result->image }}" alt="{{ $result->name }}">
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <p>Hasil pencarian tidak ditemukan.</p>
            @endif
        </div>
    </div>    
</body>
</html>

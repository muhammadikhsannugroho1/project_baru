@extends('layout.main')
@section('css')
<link rel="stylesheet" href="{{ asset("asset/css/show.css") }}"/>
@endsection

@section('content')
<h1>Detail Resep</h1>
<div class="recipe-container">
    <div class="recipe-image">
        <h2>{{ $name }}</h2>
        @if(!empty($imageUrl))
            <img src="{{ $imageUrl }}" alt="{{ $name }}" style="height:280px; width:280px">
        @else
            <p>Gambar tidak ditemukan.</p>
        @endif
    </div>
    <div class="text">
        <h3>{{ $deskripsi }}</h3>

        <h3 class="section-title">Bahan:</h3>
        @if(count($bahan) > 0)
            <p>
                @foreach($bahan as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </p>
        @else
            <p>Tidak ada bahan yang tersedia.</p>
        @endif

        <h3 class="section-title">Pembuatan:</h3>
        @if(count($pembuatan) > 0)
            <p>
                @foreach($pembuatan as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </p>
        @else
            <p>Tidak ada langkah pembuatan yang tersedia.</p>
        @endif
    </div>
</div>
@endsection




{{-- @extends('layout.main')
 @section('css')
 <link rel="stylesheet" href="{{ asset ("asset/css/show.css") }}"/>
 @endsection
@section('content')
<h1>Detail Resep</h1>
<div class="recipe-container">
    <div class="recipe-image">
        <h2>{{ $name }}</h2>
        @if(!empty($imageUrl))
             <h3 class="section-title"></h3>
            <img src="{{ $imageUrl }}" alt="{{ $name }}" style="height:280px widht:280px">
        @else
            <p>Gambar tidak ditemukan.</p>
        @endif
    </div>

    
    <div class="text">
        <h3>{{ $deskripsi }}</h3>

        <h3 class="section-title">Bahan:</h3>
        @if(count($bahan) > 0)
            <p>
                @foreach($bahan as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </p>
        @else
            <p>Tidak ada bahan yang tersedia.</p>
        @endif

        <h3 class="section-title">Pembuatan:</h3>
        @if(count($pembuatan) > 0)
            <p>
                @foreach($pembuatan as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </p>
        @else
            <p>Tidak ada langkah pembuatan yang tersedia.</p>
        @endif
    </div>
    @endsection --}}
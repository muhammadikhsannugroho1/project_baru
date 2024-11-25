@extends('layout.main')
@section('css')
 <link rel="stylesheet" href="{{ asset ("asset/css/kategori.css") }}"/>
 @endsection
@section('content')

<div class="container">
    <h2>Kategori</h2>
    <div class="recipe-grid">
        <!-- Kartu Minuman -->
        <a href="{{ route('minuman') }}">
            <div class="recipe-card">
                <div class="recipe-header">
                    <h3>Minuman</h3>
                </div>
                <div class="recipe-image">
                    <img src="{{ asset('asset/img/download (2).jpg') }}" alt="Minuman">
                </div>
            </div>
        </a>

        <!-- Kartu Makanan -->
        <a href="{{ route('makanan') }}">
            <div class="recipe-card">
                <div class="recipe-header">
                    <h3>Makanan</h3>
                </div>
                <div class="recipe-image">
                    <img src="{{ asset('asset/img/nasi-goreng-indonesian-fried-rice-sugar-spice-more-6486e9184d498a53171a2c62.jpeg') }}" alt="Makanan">
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
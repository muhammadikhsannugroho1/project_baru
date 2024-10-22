@extends('layout.main')
 @section('css')
 <link rel="stylesheet" href="{{ asset ("asset/css/dashboard.css") }}"/>
 @endsection
@section('content')

    <div class="search-container">
        <form action="/search" method="GET">
            <input type="text" placeholder="Search.." name="search" class="search-input">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div class="container">
        <h2>Resep Makanan</h2>
        <div class="recipe-grid">
            {{-- @dd($data) --}}
            @foreach ($data as $d)

                <div class="recipe-card">
                    <div class="recipe-header">
                        <h3>{{ $d->name }}</h3>
                        <span>{{ $d->kategori }}</span>
                    </div>
                    <div class="recipe-image">
                        <img src="{{ $d->image }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>    
@endsection
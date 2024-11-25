@extends('layout.main')
 @section('css')
 <link rel="stylesheet" href="{{ asset ("asset/css/dashboard.css") }}"/>
 @endsection
@section('content')

    <div class="search-container">
        <form action="{{ route('search') }}" method="GET">
            <input type="text" placeholder="Search.." name="query" class="search-input">
            <button type="submit" class="search-btn">Search</button>

            @error('search')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
        </form>
    </div>

    <div class="container">
        <h2>Resep Makanan</h2>
        <div class="recipe-grid">
            
            @foreach ($data->data as $d)
            {{-- @dd($data,$d); --}}
            <a href="{{ route('show', ['id' => $d->id]) }}">
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
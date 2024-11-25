@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ asset('asset/css/mkmm.css') }}" />
@endsection

@section('content')
    <div class="container">
        <h2>Kategori Makanan</h2>
        <div class="recipe-grid">
            @foreach ($kategori as $d)
            {{-- {{ dd($d) }} --}}
            <a href="{{ route('show', ['id' => $d->id]) }}">
                <div class="recipe-card">
                    <div class="recipe-header">
                        <h3>{{ $d->name }}</h3>
                        <span>{{ $d->kategori }}</span>
                    </div>
                    <div class="recipe-image">
                        <img src="{{ $d->image }}" alt="Image of {{ $d->name }}">
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
@endsection

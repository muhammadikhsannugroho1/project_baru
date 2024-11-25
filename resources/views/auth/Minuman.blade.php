@extends('layout.main')
 @section('css')
 <link rel="stylesheet" href="{{ asset ("asset/css/dashboard.css") }}"/>
 @endsection
@section('content')
<h2>Kategori</h2>
<div class="recipe-grid">
    @if(!empty($kategori))
    @foreach ($kategori as $d)
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
    @else
        <p>Tidak ada data kategori yang tersedia.</p>
    @endif
</div>
@endsection 
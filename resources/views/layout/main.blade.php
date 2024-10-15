<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashbaord</title>
    <link rel="stylesheet" href="{{ asset ("asset/css/app.css") }}"/>
</head>
<body>
    <header>
            <img src="{{ asset("asset/img/Dapur_Ihsan-removebg-preview.png") }}"></h1>
        {{-- nav --}}
        <nav>
            <ul><a href="{{route("dasboard")}}">HOME</a></ul>
            <ul><a href="{{ route("uplode") }}">UPLODE RESEP MU </a></ul>
            <ul><a href="{{ route("kategori") }}">KATEGORI </a></ul>
        </nav>
        {{-- prifil --}}
        <button class="btn">
            <a href={{route("login") }}>
                <img  src="{{ asset("asset/img/png-transparent-computer-icons-user-profile-circle-abstract-miscellaneous-rim-account-thumbnail-removebg-preview.png") }}">
            </a>
        </button>
    </header>
    @yield('content')  
    
    <body>
        <div class="search-container">
            <form action="/search" method="GET">
                <input type="text" placeholder="Search.." name="search" class="search-input">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>
    </body>
    
</body>
</html>
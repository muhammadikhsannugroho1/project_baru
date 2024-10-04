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
        <nav>
            <ul><a href="/dashboard">HOME</a></ul>
            <ul><a href="/daftar">DAFTAR MAKANAN</a></ul>
            <ul><a href="#">UPLODE RESEP MU </a></ul>
            <ul><a href="#">KATEGORI </a></ul>
        </nav>

        <button class="btn">
            <a href="/login">
                <img  src="{{ asset("asset/img/png-transparent-computer-icons-user-profile-circle-abstract-miscellaneous-rim-account-thumbnail-removebg-preview.png") }}">
            </a>
        </button>
    </header>
    @yield('content')    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashbaord</title>
    <link rel="stylesheet" href="{{ asset ("asset/css/app.css") }}"/>
    @yield('css')
</head>
<body>
    <header>
            <img src="{{ asset("asset/img/Dapur_Ihsan-removebg-preview.png") }}"></h1>
        {{-- nav --}}
        <nav>
            <ul><a href="{{route("dashboard")}}">HOME</a></ul>
            <ul><a href="{{ route("uplode") }}">UPLODE RESEP MU </a></ul>
            <ul><a href="{{ route("kategori") }}">KATEGORI </a></ul>
        </nav>
        
        <!-- Menu Strip Tiga (Hamburger Icon) -->
    <div class="hamburger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Dropdown Menu yang akan muncul saat diklik -->
    <div id="dropdown-menu" class="dropdown-menu">
        <div class="menu-item">
            <img src="https://img.icons8.com/ios-filled/24/000000/user.png" alt="account">
            Account
            <span>24</span>
        </div>
        <div class="line"></div>
        <div class="menu-item">
            <img src="https://img.icons8.com/ios-filled/24/000000/cookbook.png" alt="resep">
            Resep Makanan Saya
        </div>
    </div>

    </header>
    <script>
        // Fungsi untuk menampilkan atau menyembunyikan dropdown menu
        function toggleMenu() {
            var menu = document.getElementById("dropdown-menu");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        }

        // Tutup dropdown saat klik di luar area menu
        document.addEventListener('click', function(event) {
            var menu = document.getElementById("dropdown-menu");
            var hamburger = document.querySelector('.hamburger');
            
            // Jika klik di luar menu dan ikon hamburger, tutup menu
            if (!menu.contains(event.target) && !hamburger.contains(event.target)) {
                menu.style.display = "none";
            }
        });
    </script>
    @yield('content')

    
</body>
</html>
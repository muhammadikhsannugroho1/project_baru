<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="{{ asset('asset/css/app.css') }}"/>
    @yield('css')
</head>
<body>
    <header>
        <img src="{{ asset('asset/img/Dapur_Ihsan-removebg-preview.png') }}" alt="Logo">
        
        {{-- Nav --}}
        <nav>
            <ul><a href="{{ route('dashboard') }}">HOME</a></ul>
            <ul><a href="{{ route('uplode') }}">UPLODE RESEP</a></ul>
            <ul><a href="{{ route('kategori') }}">KATEGORI</a></ul>
        </nav>
        
        <!-- Menu Strip Tiga (Hamburger Icon) -->
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <!-- Dropdown Menu -->
        <div id="dropdown-menu" class="dropdown-menu">
            <div class="menu-item">
                <img src="https://img.icons8.com/ios-filled/24/000000/user.png" alt="account">
                <button><a href="{{ route('profil') }}">account</a></button>
            </div>
            <div class="line"></div>
            <div class="menu-item">
                <img src="https://img.icons8.com/ios-filled/24/000000/cookbook.png" alt="resep">
                <button><a href="{{ 'resepsaya' }}">ResepSaya</a></button>
            </div>
        </div>
    </header>

    <script>
      function checkAccountLogin() {
        console.log("Token di localStorage:", localStorage.getItem('token'));
    const token = localStorage.getItem('token'); // Ambil token dari localStorage

    if (token) {
        // Jika token ada, arahkan ke halaman profil
        window.location.href = "{{ route('profil') }}"; // Pastikan mengarah ke profil
    } else {
        // Jika token tidak ada, arahkan ke halaman login
        window.location.href = "{{ route('login') }}";
    }
}


    function checkUploadLogin() {
     const isLoggedIn = localStorage.getItem('token'); // Cek token login
        console.log({isLoggedIn})
        return false
     if (isLoggedIn) {
         // Pengguna sudah login, arahkan ke halaman upload resep
        window.location.href = "{{ route('uplode') }}"; // Ganti dengan route upload resep
     } else {
         // Pengguna belum login, arahkan ke halaman login
         window.location.href = "{{ route('login') }}";
     }
 }

function checkRecipeLogin() {
    const isLoggedIn = localStorage.getItem('token'); // Cek token login

    if (isLoggedIn) {
        // Pengguna sudah login, arahkan ke halaman makanan saya
        window.location.href = "{{ route('ResepSaya') }}"; // Ganti dengan route resep saya
    } else {
        // Pengguna belum login, arahkan ke halaman login
        window.location.href = "{{ route('login') }}";
    }
}



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

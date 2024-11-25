<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashbaord</title>
    <link rel="stylesheet" href="{{ asset ("asset/css/profil.css") }}"/>
</head>
<body>
    <h1>Profil Pengguna</h1>
        <div class="profile-info">
            <p><strong>Name:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
        </div>

        <div class="button-group">
            <button class="btn-logout"><a href="{{ route('logout') }}">logout</a></button>
            <button class="btn-back"><a href="{{ route('dashboard') }}">kembali</a></button>
        </div>
    </div>
</body>

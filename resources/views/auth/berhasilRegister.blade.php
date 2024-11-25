<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil</title>
    <link rel="stylesheet" href="{{ asset('asset/css/berhasil.css') }}"/>
</head>
<body>
    <div class="container">
        <div class="card">
            <img src="https://img.icons8.com/ios/100/000000/add-user-male.png" alt="Success Icon" class="success-icon">
            <p class="message">Terimakasih telah melakukan registrasi akun</p>
            <h1 class="title">REGISTRASI BERHASIL</h1>
            <a href="{{ route('login') }}">
                <button type="button" class="register-btn">kehalaman login</button>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" contentx="width=device-width, initial-scale=1"/>
    <title>login</title>
    <link rel="stylesheet" href="{{ asset ("asset/css/login.css") }}"/>
</head>
<body>
    <div class="login-container">
        <div class="icon-container">
            <img src="{{ asset("asset/img/png-transparent-computer-icons-user-profile-circle-abstract-miscellaneous-rim-account-thumbnail-removebg-preview.png") }}">
        </div>
        <form action="/login" method="POST">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Masukan Akun" required>
                <p class="error-message">Akun wajib di isi</p>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Masukan Password" required>
                <p class="error-message">Password wajib di isi*</p>
            </div>
            <div class="button-group">
                <button type="submit" class="login-btn">LOGIN</button>
                <button type="button" class="register-btn">REGISTER</button>
            </div>
        </form>
    </div>   
</body>
</html>


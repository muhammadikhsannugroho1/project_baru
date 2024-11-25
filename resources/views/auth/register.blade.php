<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" contentx="width=device-width, initial-scale=1"/>
    <title>register</title>
    <link rel="stylesheet" href="{{ asset ("asset/css/register.css") }}"/>
</head>
    <body>
        <div class="register-container">
            <div class="icon-container">
                <img src="{{ asset("asset/img/png-transparent-computer-icons-user-profile-circle-abstract-miscellaneous-rim-account-thumbnail-removebg-preview.png") }}">
            </div>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" id="name" name="name" placeholder="Masukan Nama" required>
                    <p class="error-message">Nama wajib di isi*</p>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Masukan Email" required>
                    <p class="error-message">Email wajib di isi*</p>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Masukan Password" required>
                    <p class="error-message">Kata sandi wajib di isi*</p>
                </div>
                <div class="form-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Sandi" required>
                    <p class="error-message">Konfirmasi kata sandi wajib di isi*</p>
                </div>
                <button type="submit" class="register-btn">Daftar</button>
            </form>
            
            </div>
        </div>
    </body>
</html>
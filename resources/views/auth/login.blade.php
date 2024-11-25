<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" href="%PUBLIC_URL%/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('asset/css/login.css') }}"/>
</head>
<body>
    <div class="login-container">
        <div class="icon-container">
            <img src="{{ asset('asset/img/png-transparent-computer-icons-user-profile-circle-abstract-miscellaneous-rim-account-thumbnail-removebg-preview.png') }}">
        </div>
      
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
                <p class="error-message">Email wajib diisi</p>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                <p class="error-message">Password wajib diisi*</p>
            </div>
            <div class="button-group">
                <button type="submit" class="login-btn">LOGIN</button>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <a href="{{ route('register') }}">
                    <button type="button" class="register-btn">REGISTER</button>
                </a>
            </div>
        </form>
    </div>   
</body>
</html>

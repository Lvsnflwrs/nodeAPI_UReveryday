<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-section {
            background-color: #e3e9f8;
            border-radius: 20px;
            padding: 50px 40px;
            width: 580px;
            height: 800px;
        }
        .image-section img {
            max-width: 100%;
            height: auto;
        }
        .container-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .women-shopping-image {
            width: 455px;
            height: 439px;
        }
        .security {
            width: 250px;
        }
    </style>
</head>
<body>
    @if($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid vh-100 d-flex align-items-center">
        <div class="row w-100">
            <div class="col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center">
                <div class="image-section">
                <img src="{{ asset('images/auth/Woman shopping online on tablet.png') }}" alt="Woman Shopping" class="women-shopping-image">
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center">
                <div class="login-section">
                    <div class="text-center mb-4">
                    <img src="{{ asset('images/auth/Group 39.png') }}" alt="Logo" class="kucing" style="width: 80px;">
                    </div>
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/auth/Online security.png') }}" alt="Security" class="security">
                    </div>
                
                    <form method="POST" action="/signup">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomorWA" class="form-label">nomor Whatsapp</label>
                            <input type="text" class="form-control" name="nomorWA" placeholder="Enter your phone number" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">SignUp</button>
                    </form>
                    <p class="text-center">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


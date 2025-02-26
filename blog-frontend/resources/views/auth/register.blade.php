{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('signup.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Kayıt Ol</title>
</head>
<body>
    {{-- Hata mesajlarını göster --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <form action="{{ route('register') }}" method="POST" class="col-12 col-md-6 col-lg-4">
            @csrf
            <div class="card shadow">
                <h2 class="title text-center">Kayıt Ol</h2>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <input type="text" id="name" name="name" placeholder="Adınızı giriniz" class="form-control mb-3" required>
                    <input type="email" id="email" name="email" placeholder="E-posta adresinizi giriniz" class="form-control mb-3" required>
                    <input type="password" id="password" name="password" placeholder="Şifre giriniz" class="form-control mb-3" required>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Şifre tekrarı giriniz" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-success w-100">Kayıt Ol</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>



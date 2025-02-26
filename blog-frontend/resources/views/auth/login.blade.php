<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('login.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Giriş Yap</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <form action="{{ route('login') }}" method="POST" class="col-12 col-md-6 col-lg-4">
            @csrf
            <div class="card shadow">
            <div class="card-header text-center">
                    <h5 class="mb-0">Giriş Yap</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    
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

                    <input type="email" name="email" placeholder="E-posta adresinizi giriniz" required class="form-control mb-3" value="{{ old('email') }}">
                    <input type="password" name="password" placeholder="Şifre giriniz" required class="form-control mb-3">
                    
                    <p class="text-center">Daha önce bir hesabınız yoksa <a href="{{ url('/register') }}">KAYIT</a> olabilirsiniz.</p>
                    
                    <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

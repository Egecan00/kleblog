<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<div class="container-fluid d-flex justify-content-center align-items-center">
    <div class="homebackground">
        <h2 class="homebackgroundtext">Sitemizi ziyaret etmek için önce kayıt olmanız gerekir.</h2>
        <h4 class="homebackgroundtext2">Daha önce bir hesabınız varsa giriş yapabilirsiniz.</h4>
        <a href="{{ url('/register') }}" class="btn btn-dark homebackgroundbutton">kayıt ol</a>
        <a href="{{ url('/login') }}" class="btn btn-dark homebackgroundbutton2">giriş yap</a>
    </div>
</div>

       

</body>


</html>
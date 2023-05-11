<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
</head>

<body>
    <header>
        <nav class="d-flex justify-content-between align-items-center p-3">
            <div>
                <img class="logo" src="{{ asset('img/logo.png') }}" alt="La cuponera">
            </div>
            <ul class="nav nav-pills justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="">Ofertas de hoy</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button"
                        aria-expanded="false">Soy un cliente</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="">Login</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="">SignUp</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button"
                        aria-expanded="false">Soy un administrador</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('AdminCompany.login') }}">Login</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="form-container">
            <div class="card">
                <form action="{{ route('AdminCompany.authenticate') }}" method="get">
                    @csrf
                    <div class="card-body">
                        <h2>LOGIN</h2>
                        @if ($errors->all())
                            <div class="alert alert-danger w-100" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p class="m-0"><?= $error ?></p>
                                @endforeach
                            </div>
                        @endif
                        <div class="w-100">
                            <div class="mb-3">
                                <input type="email" name="user-email" class="form-control" placeholder="Correo"
                                    {{ old('user-email') }}>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="user-pass" class="form-control" placeholder="Contraseña"
                                    {{ old('user-pass') }}>
                            </div>
                            <a href="{{ url('AdminCompany.forgotPassword') }}">Olvidé mi contraseña</a>
                        </div>
                        <button type="submit" name="login" class="btn">Iniciar sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
                    <a class="nav-link" aria-current="page" href="{{ route('Offers.index') }}">Ofertas</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button"
                        aria-expanded="false">Rubros</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('Categories.index') }}">Lista</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('Categories.create') }}">Crear</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button"
                        aria-expanded="false">Empresas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('Companies.index') }}">Lista</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="Companies.create">Crear</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('Clients.index') }}">Clientes</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="">
        @yield('content')
    </main>
</body>

</html>

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
                    <a class="nav-link" aria-current="page" href="{{ route('Offers.index') }}">Ofertas de hoy</a>
                </li>
                <li class="nav-item">
                    <?php
                    $count = 0;
                    if (isset($_SESSION['shoppingCart']) && count($_SESSION['shoppingCart'])) {
                        foreach ($_SESSION['shoppingCart'] as $id => $cant) {
                            $count += $cant;
                        }
                    }
                    ?>
                    <a class="nav-link position-relative" aria-current="page"
                        href="{{ route('ShoppingCart.index') }}">Carrito <span
                            class="position-absolute top-0 start-100 translate-middle badge text-bg-secondary rounded-pill"><?= $count ?></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('Coupons.index') }}">Mis cupones</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button"
                        aria-expanded="false">{{ $_SESSION['user']['user_names'] }}</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('changePassword') }}">Cambiar contraseña</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <main>
      @if (isset($_SESSION['success_message']))
          <script>
              alertify.success('<?= $_SESSION['success_message'] ?>')
          </script>
          <?php
          unset($_SESSION['success_message']);
          ?>
      @endif
      @if (isset($_SESSION['error_message']))
          <script>
              alertify.error('<?= $_SESSION['error_message'] ?>')
          </script>
          <?php
          unset($_SESSION['error_message']);
          ?>
      @endif
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
</body>

</html>

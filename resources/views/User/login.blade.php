@extends('layout.templatePublic')
@section('title', 'Login')
@section('content')
    <div class="form-container">
        <div class="card">
            <form action="{{ route('authenticate') }}" method="get">
                @csrf
                <div class="card-body">
                    <h2>LOGIN</h2>
                    @if (isset($e) && count($e))
                        <div class="alert alert-danger w-100" role="alert">
                            @foreach ($e as $error)
                                <p class="m-0"><?= $error ?></p>
                            @endforeach
                        </div>
                    @endif
                    <div class="w-100">
                        <div class="mb-3">
                            <input type="email" name="user-email" class="form-control" placeholder="Correo"
                                value="{{ old('user-email') }}">
                        </div>
                        <div class="mb-3">
                            <input type="password" name="user-pass" class="form-control" placeholder="Contraseña"
                                value="{{ old('user-pass') }}">
                        </div>
                        <a href="{{ url('forgotPassword') }}">Olvidé mi contraseña</a>
                    </div>
                    <button type="submit" name="login" class="btn btn-principal">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>
@endsection

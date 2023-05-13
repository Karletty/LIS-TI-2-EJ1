@extends('layout.templatePublic')
@section('title', 'Olvidé mi contraseña')
@section('content')
    <div class="form-container">
        <div class="card">
            <form action="{{ route('forgotPass') }}" method="post">
                @csrf
                <div class="card-body">
                    <h2>OLVIDÉ MI CONTRASEÑA</h2>
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
                    </div>
                    <button type="submit" name="login" class="btn btn-principal">Enviar</button></button>
                </div>
            </form>
        </div>
    </div>
@endsection
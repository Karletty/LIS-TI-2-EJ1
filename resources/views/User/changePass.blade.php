@extends('layout.templatePublic')
@section('title', 'Cambiar contraseña')
@section('content')
    <div class="form-container">
        <div class="card">
            <form action="{{ route('changePass') }}" method="post">
                @csrf
                <div class="card-body">
                    <h2>CAMBIAR CONTRASEÑA</h2>
                    @if (isset($e) && count($e))
                        <div class="alert alert-danger w-100" role="alert">
                            @foreach ($e as $error)
                                <p class="m-0"><?= $error ?></p>
                            @endforeach
                        </div>
                    @endif
                    <div class="w-100">
                        <div class="mb-3">
                            <input type="password" name="pass" class="form-control" placeholder="Contraseña">
                        </div>
                        <div class="mb-3">
                            <input type="password" name="repeat-pass" class="form-control" placeholder="Repetir Contraseña">
                        </div>
                    </div>
                    <button type="submit" name="login" class="btn btn-principal">Enviar</button></button>
                </div>
            </form>
        </div>
    </div>
@endsection

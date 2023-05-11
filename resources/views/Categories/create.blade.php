@extends('layout.templateAdmin')
@section('title', 'Añadir')
@section('content')
    <h1 class="mb-4">Añadir categoría</h1>
    <form action="{{ route('Categories.store') }}" method="POST">
        {{ csrf_field() }}

        <div class="mb-3">
            <label for="offer_state">Nombre</label>
            <input type="text" class="form-control" name="category_name" id="category_name" {{@old('category_name')}}>
        </div>
        <button type="submit" class="btn btn-principal">Enviar</button>
    </form>
@endsection

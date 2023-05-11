@extends('layout.templateAdmin')
@section('title', 'Editar')
@section('content')
    <h1 class="mb-4">Editar categoría {{ $category['category_id'] }}</h1>
    <form action="{{ route('Categories.update', ['Category' => $category]) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="mb-3">
            <label for="offer_state">Nombre</label>
            <input type="text" class="form-control" name="category_name" id="category_name" {{@old('category_name')}} value="{{$category['category_name']}}">
        </div>
        <button type="submit" class="btn btn-principal">Enviar</button>
    </form>
@endsection

@extends('layout.templateAdmin')
@section('title', 'Ofertas')
@section('content')
    <h1>Categorías</h1>
    <div class="overflow-x-scroll">
        <table class="table">
            <thead>
                <tr>
                    <th>Código de categoría</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category['category_id'] }}</td>
                        <td>{{ $category['category_name'] }}</td>
                        <td>
                            <a href="{{route('Categories.edit', ['Category' => $category['category_id']])}}" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                            <a href="{{route('Categories.destroy', ['Category' => $category['category_id']])}}" class="btn btn-danger"><i class="bi bi-trash3"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

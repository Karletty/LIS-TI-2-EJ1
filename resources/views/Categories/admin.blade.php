@extends('layout.templateAdmin')
@section('title', 'Categorías')
@section('content')
    <h1>Categorías</h1>
    <a href="{{ route('Categories.create') }}" class="btn btn-principal">Crear categoría</a>
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
                            <a href="{{ route('Categories.edit', $category['category_id']) }}" class="btn btn-primary"><i
                                    class="bi bi-pencil-square"></i></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

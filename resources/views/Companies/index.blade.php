@extends('layout.templateAdmin')
@section('title', 'Empresas')
@section('content')
    <h1>Empresas</h1>
    <a href="{{ route('Companies.create') }}" class="btn btn-principal">Crear empresa</a>
    <div class="overflow-x-scroll">
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Porcentaje de comisión</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->company_id }}</td>
                        <td>{{ $company->company_name }}</td>
                        <td>{{ $company->address }}</td>
                        <td>{{ $company->contact_name }}</td>
                        <td>{{ $company->phone }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->commission_percentage }}%</td>
                        <td class="mt-3 badge offer-category">{{ $company->category_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

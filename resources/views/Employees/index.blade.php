@extends('layout.templateAdminCompany')
@section('title', 'Empleados')
@section('content')
    <h1>Empleados</h1>
    <a href="{{ route('Employees.create') }}" class="btn btn-principal">Crear empleado</a>
    <hr>
    @if (count($employees) == 0)
        <h3>No tiene empleados, registre empleados para que sus clientes puedan canjear los cupones</h3>
    @else
        <div class="overflow-x-scroll">
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->last_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td class="d-flex">
                                <form action="{{ route('Employees.destroy', $employee->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i></button>
                                </form>
                                <form action="{{ route('Employees.update', $employee->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="ms-3 btn btn-primary">Reestablecer contraseña</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

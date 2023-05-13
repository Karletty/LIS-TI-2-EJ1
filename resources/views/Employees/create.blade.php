@extends('layout.templateAdminCompany')
@section('title', 'Crear empleado')
@section('content')
    <h1>Crear empleado</h1>
    <form action="{{ route('Employees.store') }}" method="POST">
        <div class="row mb-3">
            <div class="col">
                <label for="first_name" class="form-label">Nombre</label>
                <input type="text" name="first_name" id="first_name" class="form-control">
            </div>
            <div class="col">
                <label for="last_name" class="form-label">Apellido</label>
                <input type="text" name="last_name" id="last_name" class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="text" name="email" id="email" class="form-control">
        </div>
        <button type="submit" class="btn btn-principal">Guardar</button>
    </form>
@endsection

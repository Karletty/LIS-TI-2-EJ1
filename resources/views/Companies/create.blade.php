@extends('layout.templateAdmin')
@section('title', 'Crear Empresa')
@section('content')
    <h1>Crear Empresa</h1>
    @if ($errors->all())
        <div class="alert alert-danger w-100" role="alert">
            @foreach ($errors->all() as $error)
                <p class="m-0"><?= $error ?></p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('Companies.store') }}" method="post">
        @csrf
        <div class="mb-3 row">
            <div class="col">
                <label for="company_id" class="form-label">Código de empresa</label>
                <input type="text" name="company_id" class="form-control" value="{{ old('company_id') }}">
            </div>
            <div class="col">
                <label for="company_name" class="form-label">Nombre de la empresa</label>
                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label for="contact_name" class="form-label">Nombre del contacto</label>
                <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name') }}">
            </div>
            <div class="col">
                <label for="phone" class="form-label">Teléfono de contacto</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="commission_percentage" class="form-label">Porcentaje de comisión</label>
            <input type="text" name="commission_percentage" class="form-control"
                value="{{ old('commission_percentage') }}">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <select name="category" class="form-select">
                @foreach ($categories as $category)
                    <option value="{{ $category['category_id'] }}"
                        {{ old('category') == $category['category_id'] ? 'selected' : '' }}>
                        {{ $category['category_name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-principal">Crear</button>
    </form>
@endsection

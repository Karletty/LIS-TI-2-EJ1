@extends('layout.templateAdminCompany')
@section('title', 'Editar oferta')
@section('content')
    <h1>Editar oferta {{ $offer->offer_id }}</h1>
    <div class="alert alert-warning">
        <strong>Justificación del rechazo de la oferta:</strong>
        <br>{{ $offer->justification }}
    </div>
    <form action="{{ route('Offers.update', ['Offer' => $offer->offer_id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" required value="{{ $offer->title }}">
        </div>
        <div class="mb-3">
            <label for="limit_qty" class="form-label">Cantidad límite</label>
            <input type="number" class="form-control" id="limit_qty" name="limit_qty" required
                value="{{ $offer->limit_qty }}">
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="start_date" class="form-label">Fecha de inicio</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required
                    value="{{ $offer->start_date->format('Y-m-d') }}">
            </div>
            <div class="col">
                <label for="end_date" class="form-label">Fecha de fin</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required
                    value="{{ $offer->end_date->format('Y-m-d') }}">
            </div>
            <div class="col">
                <label for="deadline_date" class="form-label">Fecha límite</label>
                <input type="date" class="form-control" id="deadline_date" name="deadline_date" required
                    value="{{ $offer->deadline_date->format('Y-m-d') }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="original_price" class="form-label">Precio original</label>
                <input type="number" step="0.01" class="form-control" id="original_price" name="original_price" required
                    value="{{ $offer->original_price }}">
            </div>
            <div class="col">
                <label for="offer_price" class="form-label">Precio de oferta</label>
                <input type="number" step="0.01" class="form-control" id="offer_price" name="offer_price" required
                    value="{{ $offer->offer_price }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="offer_description" class="form-label">Descripción de la oferta</label>
            <textarea class="form-control" id="offer_description" name="offer_description" required>{{ $offer->offer_description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="details" class="form-label">Detalles</label>
            <textarea class="form-control" id="details" name="details">{{ $offer->details }}</textarea>
        </div>
        <button type="submit" class="btn btn-principal">Guardar oferta</button>
    </form>
@endsection

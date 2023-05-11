@extends('layout.templatePublic')
@section('title', 'Ofertas')
@section('content')
    <section>
        <form action="{{ route('Offers.index') }}" method="get" class="w-100" id="filters">
            <div class="filter-category">
                <label for="category">Categoría</label>
                <select name="category" class="form-control">
                    <option value="all">Todas</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_name }}"
                            {{ isset($filters['category']) && $filters['category'] == $category->category_name ? 'selected' : '' }}>
                            {{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-price">
                <label>Precio</label>
                <div class="d-flex">
                    <div class="min">
                        <input type="text" class="form-control" name="min-price" placeholder="Mín" {{ old('min-price') }}>
                    </div>
                    <div class="max">
                        <input type="text" class="form-control" name="max-price" placeholder="Max" {{ old('max-price') }}>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-filter" name="filter">Filtrar</button>
            <a href="{{ route('Offers.index') }}" class="btn btn-clear">Limpiar filtros</a>
        </form>
    </section>
    <div class="offers-container">
        @foreach ($offers as $offer)
            <div class="card col p-4">
                <h5 class="card-title">
                    <a href="{{route('Offers.show', $offer->offer_id )}}" class="btn btn-circle"
                        title="Detalles de la oferta">
                        <i class="bi bi-list-ul"></i>
                    </a>{{ $offer->title }}
                </h5>
                <img src="{{ asset('img/offers/' . $offer->offer_id . '.jpg') }}" class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column">
                    <p class="card-text mb-auto text-align-center">
                        <span
                            class="original-price">${{ number_format((float) $offer->original_price, 2, '.', '') }}</span>
                        ${{ number_format((float) $offer->offer_price, 2, '.', '') }}
                    </p>
                    <p class="card-text text-align-center"><span class="badge offer-category"><i class="bi bi-tag"></i>
                            {{ $offer->category_name }}</span></p>
                </div>
            </div>
        @endforeach
    </div>
@endsection

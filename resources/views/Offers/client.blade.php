@extends('layout.templateClient')
@section('title', 'Ofertas')
@section('content')
    <section>
        <form action="{{ route('Offers.index') }}" method="get" class="w-100" id="filters">
            <div class="filter-category">
                <label for="category">Categoría</label>
                <select name="category" class="form-control">
                    <option value="all">Todas</option>
                    @foreach ($categories as $category)
                        <option value="<?= $category['category_name'] ?>"
                            <?= isset($filters['category']) && $filters['category'] == $category['category_name'] ? 'selected' : '' ?>>
                            <?= $category['category_name'] ?></option>
                    @endforeach
                </select>
            </div>
            <div class="filter-price">
                <label>Precio</label>
                <div class="d-flex">
                    <div class="min">
                        <input type="text" class="form-control" name="min-price" placeholder="Mín"
                            value="<?= isset($filters['min-price']) ? $filters['min-price'] : '' ?>">
                    </div>
                    <div class="max">
                        <input type="text" class="form-control" name="max-price" placeholder="Max"
                            value="<?= isset($filters['max-price']) ? $filters['max-price'] : '' ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-principal btn-filter" name="filter">Filtrar</button>
            <a href="{{ route('Offers.index') }}" class="btn btn-principal btn-clear">Limpiar filtros</a>
        </form>
    </section>
    <div class="offers-container">
        <?php $count = 0; ?>
        @foreach ($offers as $offer)
            <div class="card col p-4">
                <h5 class="card-title">
                    <a href="{{ route('Offers.show', $offer['offer_id']) }}" class="btn btn-principal btn-circle"
                        title="Detalles de la oferta">
                        <i class="bi bi-list-ul"></i>
                    </a> <?= $offer['title'] ?>
                </h5>
                <img src="{{ asset('img/offers/' . $offer['offer_id'] . '.jpg') }}" class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column">
                    <p class="card-text mb-auto text-align-center">
                        <span
                            class="original-price">$<?= number_format((float) $offer['original_price'], 2, '.', '') ?></span>
                        $<?= number_format((float) $offer['offer_price'], 2, '.', '') ?>
                    </p>
                    <p class="card-text text-align-center"><span class="badge offer-category"><i class="bi bi-tag"></i>
                            <?= $offer['category_name'] ?></span></p>
                    <form method="post" action="{{ route('ShoppingCart.add', $offer['offer_id']) }}"
                        class="form-shopping d-flex flex-column align-items-center justify-content-center">
                        @csrf
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-dash-circle control me-3" id="control-reduce" onclick="reduce($count)"></i>
                            <input name="quantity" id="quantity" type="text"
                                value="{{ isset($shopping_cart) && isset($shopping_cart[$offer['offer_id']]) ? $shopping_cart[$offer['offer_id']] : '1' }}"
                                class="form-control product-cant" maxcant="<?= $offer['available_qty'] ?>">
                            <i class="bi bi-plus-circle control ms-3" id="control-add"
                                onclick="add(<?= $count ?>, <?= $offer['available_qty'] ?>)"></i>
                        </div>
                        <div class="d-flex justify-content-betwen">
                            <button name="add" type="submit" class="btn btn-principal m-3" title="Añadir al carrito"><i
                                    class="bi bi-cart-plus"></i></button>
                            <?php
                                    if (isset($shopping_cart) && isset($shopping_cart[$offer['offer_id']])) {
                                    ?>
                            <a href="{{ route('ShoppingCart.remove', $offer['offer_id']) }}" class="btn btn-principal m-3"
                                title="Quitar del carrito"><i class="bi bi-cart-x"></i></a>
                            <?php
                                    }
                                    ?>
                        </div>
                    </form>
                </div>
            </div>
            <?php $count++; ?>
        @endforeach
    </div>
    <script src="{{ asset('js/shoppingCart.js') }}"></script>
@endsection

    @extends($template)
    @section('title', 'Detalle oferta')
    @section('content')
        <div class="offer-container">
            <div class="card p-4">
                <div class="card-body">
                    <div class="container-wrap">
                        <div>
                            <img class="img-detail" src="{{ asset('img/offers/' . $offer['offer_id'] . '.jpg') }}"
                                alt="Imagen de oferta">
                            <p class="text-secondary"><strong>Disponibles: </strong><?= $offer['available_qty'] ?></p>
                        </div>
                        <div>
                            <h2 class="card-title fs-5"><?= $offer['title'] ?></h2>
                            <p><strong>Descripción: </strong><?= $offer['offer_description'] ?></p>
                            <p><strong>Categoría: </strong><?= $offer['category_name'] ?></p>
                            <p><strong>Empresa ofertante: </strong><?= $offer['company_name'] ?></p>
                            <p><strong>Fecha límite de la oferta: </strong><?= $offer['end_date'] ?></p>
                            <p><strong>Precio original:
                                </strong>$<?= number_format((float) $offer['original_price'], 2, '.', '') ?></p>
                            <p><strong>Precio de oferta:
                                </strong>$<?= number_format((float) $offer['offer_price'], 2, '.', '') ?></p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Detalles: </strong></p>
                    <?php echo $offer['details']; ?>
                    <div class="d-flex align-items-end justify-content-end">
                        <a href="{{ route('Offers.index') }}" class="mt-2 btn btn-principal">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection

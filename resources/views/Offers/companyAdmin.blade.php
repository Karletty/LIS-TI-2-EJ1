@extends('layout.templateAdminCompany')
@section('title', 'Ofertas')
@section('content')
    <h1>Ofertas</h1>
    <a href="{{ route('Offers.create') }}" class="btn btn-principal">Crear oferta</a>
    @if (count($offers) == 0)
        <h3>No tiene ninguna oferta registrada actualmente</h3>
    @else
        <div class="overflow-x-scroll">
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Precio original</th>
                        <th>Precio oferta</th>
                        <th>Empresa</th>
                        <th>Estado de oferta</th>
                        <th>Cantidad disponible</th>
                        <th>Cantidad vendida</th>
                        <th>Ingresos totales</th>
                        <th>Cargo por servicio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($offers as $offer)
                        <tr>
                            <td>{{ $offer['offer_id'] }}</td>
                            <td>{{ $offer['title'] }}</td>
                            <td>${{ number_format((float) $offer['original_price'], 2, '.', '') }}</td>
                            <td>${{ number_format((float) $offer['offer_price'], 2, '.', '') }}</td>
                            <td>{{ $offer['company_name'] }}</td>
                            <td><span
                                    class="badge {{ $offer['offer_state_id'] == 1
                                        ? 'bg-warning'
                                        : ($offer['offer_state_id'] == 2
                                            ? 'bg-success'
                                            : ($offer['offer_state_id'] == 3
                                                ? 'bg-danger'
                                                : 'bg-secondary')) }}">{{ $offer['offer_state_description'] }}</span>
                            </td>
                            <td>{{ $offer['available_qty'] }}</td>
                            <td>{{ $offer['limit_qty'] - $offer['available_qty'] }}</td>
                            <td>${{ number_format((float) ($offer['limit_qty'] - $offer['available_qty']) * $offer['offer_price'], 2, '.', '') }}
                            </td>
                            <td>${{ number_format((float) (($offer['limit_qty'] - $offer['available_qty']) * $offer['offer_price'] * $offer['commission_percentage']) / 100, 2, '.', '') }}
                            </td>
                            <td>
                                @if ($offer['offer_state_id'] != 1 && $offer['offer_state_id'] != 2)
                                    <a class="btn btn-primary"
                                        href="{{ route('Offers.edit', ['Offer' => $offer['offer_id']]) }}"><i
                                            class="bi bi-pencil-square"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

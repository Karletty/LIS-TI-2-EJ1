@extends('layout.templateAdmin')
@section('title', 'Ofertas')
@section('content')
    <h1>Ofertas</h1>
    <div class="overflow-x-scroll">
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Precio oferta</th>
                    <th>Empresa</th>
                    <th>Estado de oferta</th>
                    <th>Cantidad vendida</th>
                    <th>Cantidad disponible</th>
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
                        <td>{{ $offer['offer_price'] }}</td>
                        <td>{{ $offer['company_name'] }}</td>
                        <td><span
                                class="badge {{ $offer['offer_state_description'] == 'En espera de aprobación'
                                    ? 'bg-warning'
                                    : ($offer['offer_state_description'] == 'Aprobada'
                                        ? 'bg-success'
                                        : ($offer['offer_state_description'] == 'Rechazada'
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
                            @if ($offer['offer_state_description'] == 'En espera de aprobación')
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
@endsection

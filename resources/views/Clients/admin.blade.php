@extends('layout.templateAdmin')
@section('title', 'Clientes')
@section('content')
    <h2>Clientes</h2>
    <div class="overflow-x-scroll">
        <table class="table">
            <thead>
                <tr>
                    <th>DUI</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Está verificado</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->dui }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->address }}</td>
                        <td>
                            @if ($client->verified == 1)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>{{ $client->first_name . ' ' . $client->last_name }}</td>
                        <td>{{ $client->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <hr />
    <h2>Cupones comprados</h2>
    <div class="overflow-x-scroll">
        <table class="table">
            <thead>
                <tr>
                    <th>Código de cupón</th>
                    <th>DUI del comprador</th>
                    <th>Estado del cupón</th>
                    <th>Título</th>
                    <th>Fecha límite</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->coupon_id }}</td>
                        <td>{{ $coupon->client_dui }}</td>
                        <td>
                            @if ($coupon->state_name == 'Canjeado')
                                <span class="badge bg-success">Canjeado</span>
                            @else
                                @if ($coupon->state_name == 'Vencido')
                                    <span class="badge bg-danger">Vencido</span>
                                @else
                                    <span class="badge bg-secondary">No Canjeado</span>
                                @endif
                            @endif
                        </td>
                        <td>{{ $coupon->title }}</td>
                        <td>{{ $coupon->deadline_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layout.templateAdmin')
@section('title', 'Editar')
@section('content')
    <h1 class="mb-4">Editar oferta {{ $offer['offer_id'] }}</h1>
    <form action="{{ route('Offers.update', ['Offer' => $offer['offer_id']]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="offer_state">Estado de la oferta</label>
            <select name="offer_state" id="offer_state" class="form-select">
                @foreach ($offerStates as $offerState)
                    @if ($offerState['offer_state_id'] != 1)
                        <option value="{{ $offerState['offer_state_id'] }}">{{ $offerState['offer_state_description'] }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <textarea name="justification" id="justification" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn">Enviar</button>
    </form>
@endsection

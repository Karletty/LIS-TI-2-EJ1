@extends('layout.templateAdmin')
@section('title', 'Editar oferta')
@section('content')
    <h1 class="mb-4">Editar oferta {{ $offer['offer_id'] }}</h1>
    @if (isset($e) && count($e))
        <div class="alert alert-danger w-100" role="alert">
            @foreach ($e as $error)
                <p class="m-0"><?= $error ?></p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('Offers.update', ['Offer' => $offer['offer_id']]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="offer_state">Estado de la oferta</label>
            <select name="offer_state" id="offer_state" class="form-select">
                @foreach ($offerStates as $offerState)
                    @if ($offerState['offer_state_id'] != 1)
                        <option value="{{ $offerState['offer_state_id'] }}"
                            {{ old('offer_state') == $offerState['offer_state_id'] ? 'selected' : '' }}>
                            {{ $offerState['offer_state_description'] }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <textarea name="justification" id="justification" cols="30" rows="10" class="form-control">{{ old('justification') }}</textarea>
        </div>
        <button type="submit" class="btn btn-principal">Enviar</button>
    </form>
@endsection

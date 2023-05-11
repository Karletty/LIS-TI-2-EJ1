@extends('layout.templateAdmin')
@section('title', 'Editar')
@section('content')
    <h1 class="mb-4">Editar oferta {{ $category['category_id'] }}</h1>
    <form action="{{ route('Categories.update', $category['category_id']) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

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

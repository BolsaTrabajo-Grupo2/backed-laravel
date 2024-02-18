@extends('layouts.app')

@section('content')
<div class="container">
    <legend>Detalles de la Oferta</legend>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $offer->description }}</h5>
            <p class="card-text"><strong>Duración:</strong> {{ $offer->duration }}</p>
            <p class="card-text"><strong>Responsable:</strong> {{ $offer->responsible_name }}</p>
            <p class="card-text"><strong>Inscripción:</strong> {{ $offer->inscription_method ? 'Sí' : 'No' }}</p>
            @if($offer->observations)
                <p class="card-text"><strong>Observaciones:</strong> {{ $offer->observations }}</p>
            @endif
            <a class="col-sm-3" href="{{ route('offersStudent', ['id' => $idStudent]) }}">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection

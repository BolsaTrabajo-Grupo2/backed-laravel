<div class="container">
    <h1>Detalles de la Oferta</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $offer->description }}</h5>
            <p class="card-text"><strong>Duración:</strong> {{ $offer->duration }}</p>
            <p class="card-text"><strong>Responsable:</strong> {{ $offer->responsible_name }}</p>
            <p class="card-text"><strong>Inscripción:</strong> {{ $offer->inscription_method ? 'Sí' : 'No' }}</p>
            @if($offer->observations)
                <p class="card-text"><strong>Observaciones:</strong> {{ $offer->observations }}</p>
            @endif
            <p class="card-text"><strong>Ciclos que requiere</strong></p>
            <ul>
                @forelse($cycles as $cycle)
                    <li>{{  $cycle->cycle->cliteral }}</li>
                @empty
                    <li>No hay ciclos</li>
                @endforelse
            </ul>
            <a href="{{ route('offer.index') }}" class="btn btn-primary">Volver al Listado</a>
        </div>
    </div>
</div>

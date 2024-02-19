@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
        <legend>Detalles de la Oferta</legend>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Descripción:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $offer->description }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Duración:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $offer->duration }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Responsable:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $offer->responsible_name }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Inscripción:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $offer->inscription_method ? 'Sí' : 'No' }}
                    </div>
                </div>

                @if($offer->observations)
                    <div class="row mb-2">
                        <div class="col-md-3 text-md-right">
                            <strong>Observaciones:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $offer->observations }}
                        </div>
                    </div>
                @endif

                <div class="text-center">
                    <a href="{{ route('offersStudent', ['id' => $idStudent]) }}" class="btn btn-primary col-sm-3">Volver a la lista</a>
                </div>
            </div>
        </div>
    </div>
@endsection

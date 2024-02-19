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

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Ciclos que requiere:</strong>
                    </div>
                    <div class="col-md-9">
                        <ul>
                            @forelse($cycles as $cycle)
                                <li>{{  $cycle->cycle->cliteral }}</li>
                            @empty
                                <li>No hay ciclos</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                @if($offer->inscription_method == 1)
                    <div class="row mb-2">
                        <div class="col-md-3 text-md-right">
                            <strong>Alumnos que han aplicado:</strong>
                        </div>
                        <div class="col-md-9">
                            <ul>
                                @forelse($students as $student)
                                    <li>{{  $student->user->name }} {{ $student->user->surname }} {{ $student->user->email }}</li>
                                @empty
                                    <li>No han aplicado alumnos aún</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="text-center">
                    <a href="{{ route('offer.index') }}" class="btn btn-primary mb-3">Volver al Listado</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
@section('content')
    <div class="container">
        <legend>Listado de Ofertas</legend>
        <hr>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('offer.create') }}" class="btn btn-primary mb-3 btn-rounded">Crear Nueva Oferta</a>
            </div>
            @foreach ($offers->chunk(2) as $chunkedOffers)
                <div class="row">
                    @foreach ($chunkedOffers as $offer)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Descripción: {{ $offer->description }}</h5>
                                    <p class="card-text">Duración: {{ $offer->duration }}</p>
                                    <p class="card-text">Responsable: {{ $offer->responsible_name }}</p>
                                    <p class="card-text">Inscripción: {{ $offer->inscription_method ? 'Sí' : 'No' }}</p>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('offer.edit', $offer->id) }}" class="btn btn-primary btn-rounded mr-2">Editar</a>
                                        <a href="{{ route('offer.show', $offer->id) }}" class="btn btn-info btn-rounded mr-2">Ver Detalles</a>
                                        <form action="{{ route('offer.destroy', $offer->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-rounded" onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?')">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{ $offers->links() }}
    </div>
@endsection

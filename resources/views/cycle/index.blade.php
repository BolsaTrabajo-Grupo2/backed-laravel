@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
@section('content')
    <div class="container">
        <a href="{{ route('staticsCycles') }}" class="btn btn-sm btn-info">Ver estadísticas</a>
        <legend>Listado de Ciclos</legend>

        <div class="row">
            @foreach ($cycles as $cycle)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ciclo: {{ $cycle->cycle }}</h5>
                            <p class="card-text">Título: {{ $cycle->title }}</p>
                            <p class="card-text">Familia: {{ $cycle->family->cliteral }}</p>
                            <p class="card-text">Responsable: {{ $cycle->user->name }}</p>
                            <p class="card-text">CLiteral: {{ $cycle->cliteral }}</p>
                            <div class="btn-group" role="group">
                                <a href="{{ route('modResponsible', $cycle->id) }}" class="btn btn-info btn-rounded">Cambiar responsable</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-left">
            {{ $cycles->links() }}
        </div>
    </div>
@endsection

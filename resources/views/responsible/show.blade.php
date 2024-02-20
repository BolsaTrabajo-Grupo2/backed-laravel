@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <legend>Detalle del Responsable: {{ $responsible->name }}</legend>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4 text-md-right">
                        <strong>ID:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $responsible->id }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 text-md-right">
                        <strong>Nombre:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $responsible->name }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 text-md-right">
                        <strong>Apellido:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $responsible->surname }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 text-md-right">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $responsible->email }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Ciclos de los que es responsable:</strong>
                    </div>
                    <div class="col-md-9">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Ciclo</th>
                                <th>Título</th>
                                <th>Familia</th>
                                <th>CLiteral</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cycles as $cycle)
                                <tr>
                                    <td>{{ $cycle->cycle }}</td>
                                    <td>{{ $cycle->title }}</td>
                                    <td>{{ $cycle->family->cliteral }}</td>
                                    <td>{{ $cycle->cliteral }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 text-md-right">
                        <strong>Creado:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $responsible->created_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 text-md-right">
                        <strong>Actualizado:</strong>
                    </div>
                    <div class="col-md-6">
                        {{ $responsible->updated_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('responsible.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
                </div>
            </div>
        </div>
    </div>
@endsection


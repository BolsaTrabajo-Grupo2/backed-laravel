@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lista de Responsables</h5>
                        <a href="{{ route('responsible.create') }}" class="btn btn-primary mb-3 btn-rounded">Crear Nuevo Responsable</a>

                        <div class="row">
                            @foreach ($responsibles as $responsible)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">ID: {{ $responsible->id }}</h6>
                                            <h5 class="card-title">Nombre: {{ $responsible->name }}</h5>
                                            <p class="card-text">Email: {{ $responsible->email }}</p>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('responsible.edit', $responsible->id) }}" class="btn btn-primary btn-rounded mr-2">Editar</a>
                                                <a href="{{ route('responsible.show', $responsible->id) }}" class="btn btn-info btn-rounded mr-2">Ver Detalles</a>
                                                <form action="{{ route('responsible.destroy', $responsible->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-rounded" onclick="return confirm('¿Estás seguro de que deseas eliminar este responsable?')">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-left">
                            {{ $responsibles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

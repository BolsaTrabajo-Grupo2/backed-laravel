@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Lista de Responsables</div>

                    <div class="card-body">
                        <a href="{{ route('responsible.create') }}" class="btn btn-primary mb-3">Crear Nuevo
                            Responsable</a>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($responsibles as $responsible)
                                <tr>
                                    <th scope="row">{{ $responsible->id }}</th>
                                    <td>{{ $responsible->name }}</td>
                                    <td>{{ $responsible->email }}</td>
                                    <td>
                                        <a href="{{ route('responsible.edit', $responsible->id) }}"
                                           class="btn btn-sm btn-primary">Editar</a>
                                        <a href="{{ route('responsible.show', $responsible->id) }}"
                                           class="btn btn-sm btn-info">Ver Detalles</a>
                                        <form action="{{ route('responsible.destroy', $responsible->id) }}"
                                              method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este responsable?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Lista de Responsables</div>

                    <div class="card-body">
                        <a href="{{ route('responsable.create') }}" class="btn btn-primary mb-3">Crear Nuevo Responsable</a>

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
                            @foreach ($responsables as $responsable)
                                <tr>
                                    <th scope="row">{{ $responsable->id }}</th>
                                    <td>{{ $responsable->name }}</td>
                                    <td>{{ $responsable->email }}</td>
                                    <td>
                                        <a href="{{ route('responsable.edit', $responsable->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                        <a href="{{ route('responsable.show', $responsable->id) }}" class="btn btn-sm btn-info">Ver Detalles</a>
                                        <form action="{{ route('responsable.destroy', $responsable->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este responsable?')">Eliminar</button>
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

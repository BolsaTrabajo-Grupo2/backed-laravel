@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
@section('content')
    <div class="container">
        <legend>Listado de Estudiantes</legend>
        <hr>
        <a href="{{ route('student.create') }}" class="btn btn-primary mb-3 btn-rounded">Crear Nuevo Estudiante</a>
        <div class="row">
            @foreach ($students as $student)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Nombre: {{ $student->user->name }}</h5>
                            <p class="card-text">Apellidos: {{ $student->user->surname }}</p>
                            <p class="card-text">Email: {{ $student->user->email }}</p>
                            <p class="card-text">Ofertas Aplicadas: {{ $student->applies_count }}</p>
                            <div class="btn-group" role="group">
                                <a href="{{ route('student.edit', $student->id_user) }}" class="btn btn-primary btn-rounded mr-2">Editar</a>
                                <a href="{{ route('student.show', $student) }}" class="btn btn-info btn-rounded mr-2">Ver Detalles</a>
                                <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-rounded" onclick="return confirm('¿Estás seguro de que deseas eliminar este estudiante?')">Eliminar</button>
                                </form>
                                @if($student->user->accept == 0)
                                    <a href="{{ route('acceptStudent', $student->id_user) }}" class="btn btn-primary btn-rounded mr-2">Validar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $students->links() }}
    </div>
@endsection

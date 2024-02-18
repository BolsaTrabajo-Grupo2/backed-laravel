@extends('layouts.app')

@section('content')
    <div class="container">
        <legend>Listado de Estudiantes</legend>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Ofertas Aplicadas</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->user->name }}</td>
                        <td>{{ $student->user->surname }}</td>
                        <td>{{ $student->user->email }}</td>
                        <td>{{ $student->applies_count }}</td>
                        <td>
                            <a href="{{ route('student.edit', $student->id_user) }}" class="btn btn-primary">Editar</a>
                            <a href="{{ route('student.show', $student) }}"
                               class="btn btn-sm btn-info">Ver Detalles</a>
                            <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $students->links() }}
    </div>
@endsection

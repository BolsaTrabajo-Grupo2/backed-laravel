@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Listado de Empresas</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->surname }}</td>
                        <td>{{ $company->email }}</td>
                        <td>
                            <a href="{{ route('company.edit', $company->id) }}" class="btn btn-primary">Editar</a>
                            <form action="{{ route('company.destroy', $company->id) }}" method="POST" style="display: inline-block;">
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
    </div>
@endsection

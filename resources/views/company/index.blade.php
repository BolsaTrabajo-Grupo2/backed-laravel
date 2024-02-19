@extends('layouts.app')

@section('content')
    <div class="container">
        <legend>Listado de Empresas</legend>
        <hr>
        <div class="table-responsive">
            <a href="{{ route('company.create') }}" class="btn btn-primary mb-3">Crear Nueva
                Empresa</a>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nombre de la compañia</th>
                    <th>CIF</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($companies as $company)
                    <tr >
                        <td >{{ $company->company_name }}</td>
                        <td >{{ $company->CIF }}</td>
                        <td >{{ $company->user->name }}</td>
                        <td>{{ $company->user->surname }}</td>
                        <td>{{ $company->user->email }}</td>
                        <td>
                            <a href="{{ route('company.edit', $company->CIF) }}" class="btn btn-primary">Editar</a>
                            <a href="{{ route('company.show', $company) }}"
                               class="btn btn-sm btn-info">Ver Detalles</a>
                            <form action="{{ route('company.destroy', $company->CIF) }}" method="POST" style="display: inline-block;">
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

        {{ $companies->links() }}
    </div>
@endsection

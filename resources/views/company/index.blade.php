@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
@section('content')
    <div class="container">
        <legend>Listado de Empresas</legend>
        <hr>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('company.create') }}" class="btn btn-primary mb-3 btn-rounded">Crear Nueva Empresa</a>
            </div>
            @foreach ($companies->chunk(2) as $chunkedCompanies)
                <div class="row">
                    @foreach ($chunkedCompanies as $company)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nombre de la compañía: {{ $company->company_name }}</h5>
                                    <p class="card-text">CIF: {{ $company->CIF }}</p>
                                    <p class="card-text">Nombre: {{ $company->user->name }}</p>
                                    <p class="card-text">Apellidos: {{ $company->user->surname }}</p>
                                    <p class="card-text">Email: {{ $company->user->email }}</p>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('company.edit', $company->CIF) }}" class="btn btn-primary btn-rounded mr-2">Editar</a>
                                        <a href="{{ route('company.show', $company) }}" class="btn btn-info btn-rounded mr-2">Ver Detalles</a>
                                        <form action="{{ route('company.destroy', $company->CIF) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-rounded" onclick="return confirm('¿Estás seguro de que deseas eliminar esta empresa?')">Eliminar</button>
                                        </form>
                                        @if($company->user->accept == 0)
                                            <a href="{{ route('acceptCompany', $company->id_user) }}" class="btn btn-primary btn-rounded mr-2">Validar</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{ $companies->links() }}
    </div>
@endsection

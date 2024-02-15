@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles de la Empresa</h1>
        <hr>
        <dl class="row">

            <dt class="col-sm-3">Nombre:</dt>
            <dd class="col-sm-9">{{ $company->user->name }}</dd>

            <dt class="col-sm-3">Apellidos:</dt>
            <dd class="col-sm-9">{{ $company->user->surname }}</dd>

            <dt class="col-sm-3">Teléfono:</dt>
            <dd class="col-sm-9">{{ $company->phone }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $company->user->email }}</dd>

            <dt class="col-sm-3">CIF:</dt>
            <dd class="col-sm-9">{{ $company->CIF }}</dd>

            <dt class="col-sm-3">Nombre de la Empresa:</dt>
            <dd class="col-sm-9">{{ $company->company_name }}</dd>

            <dt class="col-sm-3">Web:</dt>
            <dd class="col-sm-9">{{ $company->web }}</dd>

            <dt class="col-sm-3">Dirección:</dt>
            <dd class="col-sm-9">{{ $company->address }}</dd>

            <dt class="col-sm-3">CP:</dt>
            <dd class="col-sm-9">{{ $company->CP }}</dd>
        </dl>
        <a href="{{ route('company.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
    </div>
@endsection

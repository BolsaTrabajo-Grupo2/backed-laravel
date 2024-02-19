@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <legend>Detalles de la Empresa</legend>
            <hr>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Nombre:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->user->name }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Apellidos:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->user->surname }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Teléfono:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->phone }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->user->email }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>CIF:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->CIF }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Nombre de la Empresa:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->company_name }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Web:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->web }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Dirección:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->address }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>CP:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $company->CP }}
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('company.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
                </div>
            </div>
        </div>
    </div>
@endsection

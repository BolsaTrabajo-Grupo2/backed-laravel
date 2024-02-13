@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Detalles del Responsable</div>

            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">ID</label>
                    <div class="col-md-6">
                        <p>{{ $responsable->id }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
                    <div class="col-md-6">
                        <p>{{ $responsable->name }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="surname" class="col-md-4 col-form-label text-md-right">Apellido</label>
                    <div class="col-md-6">
                        <p>{{ $responsable->surname }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                    <div class="col-md-6">
                        <p>{{ $responsable->email }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="created_at" class="col-md-4 col-form-label text-md-right">Creado</label>
                    <div class="col-md-6">
                        <p>{{ $responsable->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="updated_at" class="col-md-4 col-form-label text-md-right">Actualizado</label>
                    <div class="col-md-6">
                        <p>{{ $responsable->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
                <a href="{{ route('responsable.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
            </div>
        </div>
    </div>
@endsection

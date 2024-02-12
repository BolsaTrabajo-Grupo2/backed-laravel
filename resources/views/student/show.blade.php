@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles del Estudiante</h1>
        <hr>
        <dl class="row">
            <dt class="col-sm-3">Nombre:</dt>
            <dd class="col-sm-9">{{ $student->name }}</dd>

            <dt class="col-sm-3">Apellidos:</dt>
            <dd class="col-sm-9">{{ $student->surname }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $student->email }}</dd>

            <dt class="col-sm-3">Dirección:</dt>
            <dd class="col-sm-9">{{ $student->address }}</dd>

            <dt class="col-sm-3">Link Curriculum:</dt>
            <dd class="col-sm-9">{{ $student->cv_link }}</dd>
        </dl>
    </div>
@endsection

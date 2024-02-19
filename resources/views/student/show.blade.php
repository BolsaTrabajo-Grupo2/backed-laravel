@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <legend>Detalles del Estudiante</legend>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Nombre:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $student->user->name }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Apellidos:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $student->user->surname }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $student->user->email }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Dirección:</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $student->address }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Ciclos Cursados:</strong>
                    </div>
                    <div class="col-md-9">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Ciclo</th>
                                <th>Título</th>
                                <th>Familia</th>
                                <th>CLiteral</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cursedCycles as $cycle)
                                <tr>
                                    <td>{{ $cycle->cycle }}</td>
                                    <td>{{ $cycle->title }}</td>
                                    <td>{{ $cycle->family->cliteral }}</td>
                                    <td>{{ $cycle->cliteral }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 text-md-right">
                        <strong>Link Curriculum:</strong>
                    </div>
                    <div class="col-md-9">
                        @if($student->cv_link == null)
                            <p>El estudiante no tiene CV</p>
                        @endif
                        {{ $student->cv_link }}
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('offersStudent', ['id' => $student->id]) }}" class="btn btn-primary col-sm-3">Ofertas a las que ha aplicado el Estudiante</a>
                </div>

                <div class="text-center">
                    <a href="{{ route('student.index') }}" class="btn btn-primary">Volver al Listado</a>
                </div>
            </div>
        </div>
    </div>
@endsection

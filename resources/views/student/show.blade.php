@extends('layouts.app')

@section('content')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <div class="container">
        <h1>Detalles del Estudiante</h1>
        <hr>
        <dl class="row">
            <dt class="col-sm-3">Nombre:</dt>
            <dd class="col-sm-9">{{ $student->user->name }}</dd>

            <dt class="col-sm-3">Apellidos:</dt>
            <dd class="col-sm-9">{{ $student->user->surname }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $student->user->email }}</dd>

            <dt class="col-sm-3">Dirección:</dt>
            <dd class="col-sm-9">{{ $student->address }}</dd>

            <dt class="col-sm-3">Ciclos Cursados:</dt>
                <table>
                    <thead>
                    <tr>
                        <th>Ciclo</th>
                        <th>Titulo</th>
                        <th>Familia</th>
                        <th>CLiteral</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cursedCycles as $cycle)
                    <tr>
                        <td>{{$cycle->cycle}}</td>
                        <td>{{$cycle->title}}</td>
                        <td>{{$cycle->family->cliteral}}</td>
                        <td>{{$cycle->cliteral}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            <dt class="col-sm-3">Link Curriculum:</dt>
            <dd class="col-sm-9">{{ $student->cv_link }}</dd>
        </dl>
    </div>
@endsection

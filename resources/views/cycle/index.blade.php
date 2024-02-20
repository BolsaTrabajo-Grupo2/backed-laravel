@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('staticsCycles') }}"
           class="btn btn-sm btn-info">Ver estadisticas</a>
        <legend>Listado de Ciclos</legend>
        <table class="table">
            <thead>
            <tr>
                <th>Ciclo</th>
                <th>Titulo</th>
                <th>Familia</th>
                <th>Responsable</th>
                <th>CLiteral</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($cycles as $cycle)
                <tr>
                    <td>{{ $cycle->cycle }}</td>
                    <td>{{ $cycle->title }}</td>
                    <td>{{ $cycle->family->cliteral }}</td>
                    <td>{{ $cycle->user->name }}</td>
                    <td>{{ $cycle->cliteral }}</td>
                    <td>
                        <a href="{{ route('modResponsible', $cycle->id) }}"
                           class="btn btn-sm btn-info">Cambiar responsable</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $cycles->links() }}
    </div>
@endsection

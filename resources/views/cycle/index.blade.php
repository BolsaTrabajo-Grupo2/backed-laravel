@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Listado de Ciclos</h1>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ciclo</th>
                <th>Título</th>
                <th>Cantidad de Ofertas</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cycles as $cycle)
                <tr>
                    <td>{{ $cycle->id }}</td>
                    <td>{{ $cycle->cycle }}</td>
                    <td>{{ $cycle->title }}</td>
                    <td>
                        @if($cycle->offers_count > 0)
                            {{ $cycle->offers_count }}
                        @else
                            No hay ofertas en este momento
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $cycles->links() }}
    </div>
@endsection


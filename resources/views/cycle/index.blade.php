@extends('layouts.app')

@section('content')
    <div class="container">
        <legend>Listado de Ciclos</legend>
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');
        const cycles = {!! json_encode($cycles->pluck('cycle')) !!};
        const assignmentsCounts = {!! json_encode($cycles->map(function ($cycle) {
            return $cycle->assigneds->count();
        })) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cycles,
                datasets: [{
                    label: 'Cantidad de Ofertas',
                    data: assignmentsCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

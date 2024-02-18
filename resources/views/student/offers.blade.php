<div class="container">
    @if($offers->count() > 0)
    <h1>Listado de Ofertas del Estudiante</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Descripción</th>
            <th>Duración</th>
            <th>Responsable</th>
            <th>Inscripción</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($offers as $offer)
            <tr>
                <td>{{ $offer->description }}</td>
                <td>{{ $offer->duration }}</td>
                <td>{{ $offer->responsible_name }}</td>
                <td>{{ $offer->inscription_method ? 'Sí' : 'No' }}</td>
                <td>
                    <a href="{{ route('offerShow', ['id' => $offer->id,'idStudent' => $idStudent]) }}" class="btn btn-sm btn-info">Ver Detalles</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <h1>El estudiante no tiene ofertas registradas</h1>
    @endif
    <a href="{{ route('student.show',$idStudent) }}" class="btn btn-primary">Volver a los detalles</a>
</div>

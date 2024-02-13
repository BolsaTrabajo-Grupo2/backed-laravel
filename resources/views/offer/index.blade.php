<div class="container">
    <h1>Listado de Ofertas</h1>
    <a href="{{ route('offer.create') }}" class="btn btn-primary mb-3">Crear Nueva Oferta</a>
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
                    <a href="{{ route('oferta.edit', $offer->id) }}" class="btn btn-primary">Editar</a>
                    <form method="POST" action="{{ route('oferta.destroy', $offer->id) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?')">Borrar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

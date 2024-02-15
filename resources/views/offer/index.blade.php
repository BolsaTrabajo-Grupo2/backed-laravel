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
                    <a href="{{ route('offer.show', $offer->id) }}"
                       class="btn btn-sm btn-info">Ver Detalles</a>
                    <a href="{{ route('offer.edit', $offer->id) }}"
                       class="btn btn-sm btn-primary">Editar</a>
                    <form action="{{ route('offer.destroy', $offer->id) }}"
                          method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este responsable?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

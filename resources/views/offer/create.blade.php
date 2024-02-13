<div class="row">
    <form method="POST" action="{{ route('offer.store') }}">
        @csrf
        <fieldset>
            <legend>Crear Nueva Oferta</legend>

            <div class="form-group">
                <label for="description">Descripción del puesto de trabajo ofertado:</label><br />
                <input name="description" type="text" class="form-control" />
                @error('description')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Duración del contrato:</label><br />
                <input name="duration" type="text" class="form-control" />
                @error('duration')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="responsible_name">Nombre del responsable:</label><br />
                <input name="responsible_name" type="text" class="form-control" />
                @error('responsible_name')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="inscription_method">¿Deseas que los alumnos se apunten aquí?</label><br />
                <input name="inscription_method" type="checkbox" value="1" class="form-check-input" />
                @error('inscription_method')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="observations">Observaciones:</label><br />
                <textarea name="observations" class="form-control"></textarea>
                @error('observations')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="CIF">CIF:</label><br />
                <input name="CIF" type="text" class="form-control" />
                @error('CIF')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <br />

            <button type="submit" class="btn btn-primary">Guardar</button>
        </fieldset>
    </form>
</div>

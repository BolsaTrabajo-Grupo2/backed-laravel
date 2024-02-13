<div class="row">
    <form method="POST" action="{{ route('offer.update', $offer->id) }}">
        @csrf
        @method('PUT')
        <fieldset>
            <legend>Editar Oferta</legend>

            <div class="form-group">
                <label for="description">Descripción del puesto de trabajo ofertado:</label><br/>
                <input name="description" type="text" class="form-control" value="{{ $offer->description }}"/>
                @error('description')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Duración del contrato:</label><br/>
                <input name="duration" type="text" class="form-control" value="{{ $offer->duration }}"/>
                @error('duration')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="responsible_name">Nombre del responsable:</label><br/>
                <input name="responsible_name" type="text" class="form-control" value="{{ $offer->responsible_name }}"/>
                @error('responsible_name')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="inscription_method">¿Deseas que los alumnos se apunten aquí?</label><br/>
                <input name="inscription_method" type="checkbox" class="form-check-input"
                       value="1" {{ $offer->inscription_method ? 'checked' : '' }} />
                @error('inscription_method')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="observations">Observaciones:</label><br/>
                <textarea name="observations" class="form-control">{{ $offer->observations }}</textarea>
                @error('observations')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="CIF">CIF:</label><br/>
                <input name="CIF" type="text" class="form-control" value="{{ $offer->CIF }}"/>
                @error('CIF')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <br/>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </fieldset>
    </form>
</div>

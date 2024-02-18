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
                <label for="selectedCycles">Seleccione los ciclos de la oferta:</label><br />
                <select name="selectedCycles[]" id="selectedCycles" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                    @foreach ($cycles as $cycle)
                        <option value="{{ $cycle->id }}" @if($cyclesOffer->contains('id_cycle', $cycle->id)) selected @endif>
                            {{ $cycle->cliteral }}
                        </option>
                    @endforeach
                </select>
                @error('selectedCycles')
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

            <<div class="form-group">
                <label for="CIF">Selecciona la empresa a la que pertenece la oferta:</label><br />
                <select name="CIF" id="CIF" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($companies as $company)
                        <option value="{{ $company->CIF }}" @if($company->CIF == $offer->CIF) selected @endif>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('CIF')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>
            <br/>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </fieldset>
    </form>
    <div class="col-md-6 offset-md-4">
        <a href="{{ route('offer.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
    </div>
</div>

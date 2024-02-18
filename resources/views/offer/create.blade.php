@extends('layouts.app')

@section('content')
<div class="row">

    <form method="POST" action="{{ route('offer.store') }}">
        @csrf
        <fieldset>
            <legend>Crear Nueva Oferta</legend>

            <div class="form-group">
                <label for="description">Descripción del puesto de trabajo ofertado:</label><br/>
                <input name="description" type="text" class="form-control" value="{{ old('description') }}"/>
                @error('description')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Duración del contrato:</label><br/>
                <input name="duration" type="text" class="form-control" value="{{ old('duration') }}"/>
                @error('duration')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="selectedCycles">Seleccione los ciclos para quien sea la oferta:</label><br/>
                <select name="selectedCycles[]" id="selectedCycles"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        multiple>
                    @foreach ($cycles as $cycle)
                        <option value="{{ $cycle->id }}">
                            {{ $cycle->title }}
                        </option>
                    @endforeach
                </select>
                @error('selectedCycles')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="responsible_name">Nombre del responsable:</label><br/>
                <input name="responsible_name" type="text" class="form-control" value="{{ old('responsible_name') }}"/>
                @error('responsible_name')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="inscription_method">¿Deseas que los alumnos se apunten aquí?</label><br/>
                <input name="inscription_method" type="checkbox" value="1" class="form-check-input"
                       @if(old('inscription_method')) checked @endif />
                @error('inscription_method')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="observations">Observaciones:</label><br/>
                <textarea name="observations" class="form-control">{{ old('observations') }}</textarea>
                @error('observations')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="CIF">Selecciona la empresa a la que pertenece la oferta:</label><br/>
                <select name="CIF" id="CIF"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($companies as $company)
                        <option value="{{ $company->CIF }}">
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('CIF')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <br/>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </fieldset>
        <a href="{{ route('offer.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
    </form>
</div>
@endsection

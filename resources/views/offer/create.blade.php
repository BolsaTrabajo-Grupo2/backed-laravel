@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">
    <form method="POST" action="{{ route('offer.store') }}">
        @csrf
        <fieldset>
            <legend>Crear Nueva Oferta</legend>

            <div class="form-group">
                <label for="description">Descripción del puesto de trabajo ofertado:</label>
                <input name="description" type="text" class="form-control" value="{{ old('description') }}" />
                @error('description')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="duration">Duración del contrato:</label>
                <input name="duration" type="text" class="form-control" value="{{ old('duration') }}" />
                @error('duration')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" id="app">
                <label for="selectedCycles">Seleccione los ciclos para quien sea la oferta:</label>
                <div class="cycle-container">
                    <div class="input-group cycle-field" v-for="(cycle, index) in selectedCycles" :key="index">
                        <select name="selectedCycles[]" class="form-control" v-model="cycle.id" @change="addCycleField(index)">
                            <option value="">Seleccionar ciclo</option>
                            @foreach ($cycles as $cycle)
                                <option value="{{ $cycle->id }}">{{ $cycle->title }}</option>
                            @endforeach
                        </select>
                        <button type="button" @click="removeCycleField(index)" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
                @error('selectedCycles')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="responsible_name">Nombre del responsable:</label>
                <input name="responsible_name" type="text" class="form-control" value="{{ old('responsible_name') }}" />
                @error('responsible_name')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input name="inscription_method" type="checkbox" value="1" class="form-check-input" @if(old('inscription_method')) checked @endif />
                    <label class="form-check-label" for="inscription_method">¿Deseas que los alumnos se apunten aquí?</label>
                </div>
                @error('inscription_method')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="observations">Observaciones:</label>
                <textarea name="observations" class="form-control">{{ old('observations') }}</textarea>
                @error('observations')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="CIF">Selecciona la empresa a la que pertenece la oferta:</label>
                <select name="CIF" id="CIF" class="form-control">
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

            <br />

            <button type="submit" class="btn btn-primary">Guardar</button>
        </fieldset>
        <a href="{{ route('offer.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            selectedCycles: [{
                id: ''
            }],
        },
        methods: {
            addCycleField(index) {
                if (index === this.selectedCycles.length - 1 && this.selectedCycles[index].id !== '') {
                    this.selectedCycles.push({
                        id: ''
                    });
                }
            },
            removeCycleField(index) {

                this.selectedCycles.splice(index, 1);

                if (this.selectedCycles.length === 0) {
                    this.selectedCycles.push({
                        id: ''
                    });
                }
            },
        },
    });
</script>
</body>

</html>
@endsection

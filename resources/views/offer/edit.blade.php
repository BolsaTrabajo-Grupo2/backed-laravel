@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
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

            <div class="form-group" id="app">
                <label for="selectedCycles">Seleccione los ciclos de la oferta:</label>
                <div class="cycle-container">
                    <div class="input-group cycle-field" v-for="(cycle, index) in selectedCycles" :key="index">
                        <select name="selectedCycles[]" class="form-control" v-model="cycle.id" @change="addCycleField(index)">
                            <option value="">Seleccionar ciclo</option>
                            @foreach ($cycles as $cycleOption)
                                <option value="{{ $cycleOption->id }}" @if($cyclesOffer->contains('id_cycle', $cycleOption->id)) selected @endif>
                                    {{ $cycleOption->cliteral }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" @click="removeCycleField(index)">Eliminar</button>
                    </div>
                </div>
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

            <div class="form-group">
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
        <a href="{{ route('offer.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            selectedCycles: [{ id: '' }],
        },
        mounted() {

            this.selectedCycles = {!! json_encode($cyclesOffer->pluck('id_cycle')) !!}.map(id => ({ id }));

            if (this.selectedCycles.length === 0) {
                this.selectedCycles.push({ id: '' });
            }

            if (this.selectedCycles.every(cycle => cycle.id !== '')) {
                this.selectedCycles.push({ id: '' });
            }
        },
        methods: {
            addCycleField(index) {
                if (index === this.selectedCycles.length - 1 && this.selectedCycles[index].id !== '') {
                    this.selectedCycles.push({ id: '' });
                }
            },
            removeCycleField(index) {

                this.selectedCycles.splice(index, 1);

                if (this.selectedCycles.length === 0) {
                    this.selectedCycles.push({ id: '' });
                }
            },
        },
    });
</script>
</body>
</html>
@endsection

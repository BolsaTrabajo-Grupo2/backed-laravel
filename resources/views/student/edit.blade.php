@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ route('student.update', $student->id) }}">
            @csrf
            @method('PUT')
            <fieldset>
                <legend>Editar Estudiante</legend>

                <div class="form-group">
                    <label class="col-md-4 control-label">Nombre</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <input name="nombre" placeholder="nombre" class="form-control" type="text"
                                   value="{{ $student->nombre }}" />
                            @error('nombre')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group" v-for="(cycleField, index) in cycleFields" :key="index">
                    <label class="col-md-4 control-label">Ciclo</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <select v-model="cycleField.selectedCycle" class="form-control" @change="addCycleField(index)">
                                <option value="">Seleccionar ciclo</option>
                                <option v-for="cycle in cycles" :key="cycle.id" :value="cycle.id">{{ cycle.title }}</option>
                            </select>
                            <input type="date" v-model="cycleField.date" class="form-control" />
                            <button @click="removeCycleField(index)">Eliminar</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Dirección</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <input name="direccion" placeholder="direccion" class="form-control" type="text"
                                   value="{{ $student->direccion }}" />
                            @error('direccion')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Link Curriculum</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <input name="cv" placeholder="cv" class="form-control" type="text"
                                   value="{{ $student->cv }}" />
                            @error('cv')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Términos y Condiciones</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <input name="aceptar" type="checkbox" class="form-check-input" />
                            <label class="form-check-label" for="aceptar">Acepto los términos y condiciones</label>
                        </div>
                        @error('aceptar')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning">Actualizar <span
                                class="glyphicon glyphicon-send"></span></button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection

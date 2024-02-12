@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ route('student.store') }}">
            @csrf
            <fieldset>
                <legend>Registrarse</legend>

            <div class="form-group">
                <label class="col-md-4 control-label">Nombre</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <input name="nombre" placeholder="nombre" class="form-control" type="text"
                               value="{{ old('nombre') }}" />
                        @error('nombre')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Apellido</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <input name="apellidos" placeholder="apellido" class="form-control" type="text"
                               value="{{ old('apellidos') }}" />
                        @error('apellidos')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">E-Mail</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <input name="email" placeholder="email" class="form-control" type="email"
                               value="{{ old('email') }}" />
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Contraseña</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <input name="contraseña" placeholder="contraseña" class="form-control" type="password" />
                        @error('contraseña')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Repetir Contraseña</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <input name="repetirContraseña" placeholder="repetir contraseña" class="form-control"
                               type="password" />
                        @error('repetirContraseña')
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
                               value="{{ old('direccion') }}" />
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
                               value="{{ old('cv') }}" />
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
                    <button type="submit" class="btn btn-warning">Registrarse <span
                            class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

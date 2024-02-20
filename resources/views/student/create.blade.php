@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">
    <form method="POST" action="{{ route('student.store') }}" id="studentForm">
        @csrf
        <fieldset>
            <legend>Crear un nuevo Estudiante</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Nombre:</label>
                    <input name="name" type="text" class="form-control" />
                    @error('name')
                    <span class="validate-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="surname">Apellidos:</label>
                    <input name="surname" type="text" class="form-control" />
                    @error('surname')
                    <span class="validate-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input name="email" type="text" class="form-control" />
                @error('email')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input name="password" type="password" class="form-control" />
                @error('password')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="confirmPassword">Repetir Contraseña:</label>
                <input name="confirmPassword" type="password" class="form-control" />
                @error('confirmPassword')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" id="app">
                <label for="ciclo">Ciclo:</label>
                <div class="cycle-container">
                    <div class="input-group cycle-field">
                        <select name="cycles[]" class="form-control" onchange="addCycleField(this)">
                            <option value="">Seleccionar ciclo</option>
                            @foreach ($cycles as $cycle)
                                <option value="{{ $cycle->id }}">{{ $cycle->title }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="dates[]" class="form-control" />
                        <button type="button" onclick="removeCycleField(this)">Eliminar</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Dirección:</label>
                <input name="address" type="text" class="form-control" />
                @error('address')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="observations">Observaciones:</label>
                <input name="observations" type="text" class="form-control" />
                @error('observations')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="CVLink">Enlace al Curriculum:</label>
                <input name="CVLink" type="text" class="form-control" />
            </div>

            <div class="form-group">
                <input name="aceptar" type="checkbox" value="1" />
                <span class="form-check-label"> Acepto los términos y condiciones</span>
                @error('aceptar')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="hidden" name="rol" value="COMP" />
            </div>

            <button type="submit" class="btn btn-default btn-primary">Crear</button>
        </fieldset>
    </form>
    <a href="{{ route('company.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function addCycleField(select) {
            var selectedCycle = $(select).val();

            if (selectedCycle) {
                var container = $(select).closest('.cycle-container');
                var clone = container.find('.cycle-field:first').clone();
                clone.find('select').val('');
                clone.find('input').val('');
                container.append(clone);
            }
        }

        function removeCycleField(button) {
            var cycleFields = $(button).closest('.cycle-field');

            if (cycleFields.siblings('.cycle-field').length > 0) {
                cycleFields.remove();
            }
        }
    </script>
</div>
</body>

</html>
@endsection

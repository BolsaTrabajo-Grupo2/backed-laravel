<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="container">
        <h1>Editar Estudiante</h1>
        <hr>
        <div class="row">
            <form id="editForm" method="POST" action="{{ route('student.update', ['student' => $student->id_user]) }}">
                @csrf
                @method('PUT')
                <fieldset>
                    <div>
                        <label for="name">Nombre:</label><br />
                        <input name="name" type="text" value="{{ $student->user->name }}" /><br />
                        @error('name')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>
                    <div>
                        <label for="surname">Apellidos:</label><br />
                        <input name="surname" type="text" value="{{ $student->user->surname }}" /><br />
                        @error('surname')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>

                    <div>
                        <label for="email">Email:</label><br />
                        <input name="email" type="text" value="{{ $student->user->email }}" /><br />
                        @error('email')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>

                    <div>
                        <label for="password">Contraseña:</label><br />
                        <input name="password" type="password" /><br />
                        @error('password')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>

                    <div>
                        <label for="confirmPassword">Repetir Contraseña:</label><br />
                        <input name="confirmPassword" type="password" /><br />
                        @error('confirmPassword')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>

                    <div class="form-group" id="app">
                        <label for="cycles">Ciclos:</label><br />
                        <div class="cycle-container">
                            @foreach($student->studies as $index => $study)
                                <div class="input-group cycle-field">
                                    <select name="cycles[]" class="form-control">
                                        <option value="">Seleccionar ciclo</option>
                                        @foreach ($cycles as $cycle)
                                            <option value="{{ $cycle->id }}" {{ $study->id_cycle == $cycle->id ? 'selected' : '' }}>
                                                {{ $cycle->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="date" name="dates[]" class="form-control" value="{{ $study->date }}"/>
                                    <button type="button" class="remove-field">Eliminar</button>
                                </div>
                            @endforeach
                            <div class="input-group cycle-field">
                                <select name="cycles[]" class="form-control">
                                    <option value="">Seleccionar ciclo</option>
                                    @foreach ($cycles as $cycle)
                                        <option value="{{ $cycle->id }}">{{ $cycle->title }}</option>
                                    @endforeach
                                </select>
                                <input type="date" name="dates[]" class="form-control"/>
                                <button type="button" class="remove-field">Eliminar</button>
                            </div>
                        </div>
                        @error('cycles')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>


                    <div>
                        <label for="address">Dirección:</label><br />
                        <input name="address" type="text" value="{{ $student->address }}" /><br />
                        @error('address')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>

                    <div>
                        <label for="observations">Observaciones:</label><br />
                        <input name="observations" type="text" value="{{ $student->observations }}" /><br />
                        @error('observations')
                        <span class="validate-error">{{ $message }}</span><br />
                        @enderror
                    </div>

                    <div>
                        <label for="CVLink">Link Curriculum:</label><br />
                        <input name="CVLink" type="text" value="{{ $student->cv_link }}" /><br />
                    </div>

                    <button type="submit" class="btn btn-default btn-primary">Editar</button>
                </fieldset>
            </form>
            <a href="{{ route('student.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
        </div>
    <script>
        $(document).ready(function() {
            $(".cycle-container").on("change", "select[name='cycles[]']", function() {
                var selectedCycle = $(this).val();
                if (selectedCycle) {
                    var container = $(this).closest('.cycle-container');
                    var clone = container.find('.cycle-field:first').clone();
                    clone.find('select').val('');
                    clone.find('input').val('');
                    container.append(clone);
                }
            });

            $(".cycle-container").on("click", ".remove-field", function() {
                var cycleFields = $(this).closest('.cycle-container').find('.cycle-field');
                if (cycleFields.length > 1) {
                    $(this).closest('.cycle-field').remove();
                }
            });
        });
    </script>
    </div>
</body>
</html>


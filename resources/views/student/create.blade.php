<div class="row">
    <form method="POST" action="{{ route('student.store') }}" id="studentForm">
        @csrf
        <fieldset>
            <legend>Crear una nuevo Estudiante</legend>

            <div>
                <div>
                    <label for="name">Nombre:</label><br />
                    <input name="name" type="text" /><br />
                    @error('name')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="surname">Apellidos:</label><br />
                    <input name="surname" type="text"/><br />
                    @error('surname')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="phone">Teléfono:</label><br />
                    <input name="phone" type="text" /><br />
                    @error('phone')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="email">Email:</label><br />
                    <input name="email" type="text"/><br />
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

                <div>
                    <label for="address">Direccion:</label><br />
                    <input name="address" type="text"/><br />
                    @error('address')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="CVLink">Linck Curriculum:</label><br />
                    <input name="CVLink" type="text"/><br />
                </div>

                <div>
                    <input name="aceptar" type="checkbox" value="1" />
                    <span class="form-check-label"> Acepto los términos y condiciones</span><br />
                    @error('aceptar')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>
            </div>

            <div>
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

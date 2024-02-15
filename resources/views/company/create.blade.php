<div class="row">
    <form method="POST" action="{{ route('company.store') }}">
        @csrf
        <fieldset>
            <legend>Crear una nueva Emrpesa</legend>

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

                <div>
                    <label for="CIF">CIF:</label><br />
                    <input name="CIF" type="text"/><br />
                    @error('CIF')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="company_name">Nombre Empresa:</label><br />
                    <input name="company_name" type="text"/><br />
                    @error('companyName')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="web">Web:</label><br />
                    <input name="web" type="text"/><br />
                    @error('web')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="address">Dirección:</label><br />
                    <input name="address" type="text"/><br />
                    @error('address')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="CP">CP:</label><br />
                    <input name="CP" type="text"/><br />
                    @error('CP')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
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
</div>

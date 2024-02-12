<div class="row">
    <form method="POST" action="{{ route('company.store') }}">
        @csrf
        <fieldset>
            <legend>{{ $titulo }}</legend>

            <div>
                <div>
                    <label for="name">Nombre:</label><br />
                    <input name="name" type="text" value="{{ old('name') }}" /><br />
                    @error('name')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="surname">Apellidos:</label><br />
                    <input name="surname" type="text" value="{{ old('surname') }}" /><br />
                    @error('surname')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="phone">Teléfono:</label><br />
                    <input name="phone" type="text" value="{{ old('phone') }}" /><br />
                    @error('phone')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="email">Email:</label><br />
                    <input name="email" type="text" value="{{ old('email') }}" /><br />
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
                    <input name="CIF" type="text" value="{{ old('CIF') }}" /><br />
                    @error('CIF')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="companyName">Nombre Empresa:</label><br />
                    <input name="companyName" type="text" value="{{ old('companyName') }}" /><br />
                    @error('companyName')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="web">Web:</label><br />
                    <input name="web" type="text" value="{{ old('web') }}" /><br />
                    @error('web')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="address">Dirección:</label><br />
                    <input name="address" type="text" value="{{ old('address') }}" /><br />
                    @error('address')
                    <span class="validate-error">{{ $message }}</span><br />
                    @enderror
                </div>

                <div>
                    <label for="CP">CP:</label><br />
                    <input name="CP" type="text" value="{{ old('CP') }}" /><br />
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

            <button type="submit" class="btn btn-default btn-primary">{{ $boton }}</button>
        </fieldset>
    </form>
</div>

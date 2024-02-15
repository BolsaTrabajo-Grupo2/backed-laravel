@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Empresa</h1>
        <hr>
        <div class="row">
            <form method="POST" action="{{ route('company.update', $company->id_user) }}">
                @csrf
                @method('PUT')
                <fieldset>

                    <div>
                        <div>
                            <label for="name">Nombre:</label><br />
                            <input name="name" type="text" value="{{ $company->user->name }}" /><br />
                            @error('name')
                            <span class="validate-error">{{ $message }}</span><br />
                            @enderror
                        </div>

                        <div>
                            <label for="surname">Apellidos:</label><br />
                            <input name="surname" type="text" value="{{ $company->user->surname }}" /><br />
                            @error('surname')
                            <span class="validate-error">{{ $message }}</span><br />
                            @enderror
                        </div>

                        <div>
                            <label for="phone">Teléfono:</label><br />
                            <input name="phone" type="text" value="{{ $company->phone }}" /><br />
                            @error('phone')
                            <span class="validate-error">{{ $message }}</span><br />
                            @enderror
                        </div>

                        <div>
                            <label for="email">Email:</label><br />
                            <input name="email" type="text" value="{{ $company->user->email }}" /><br />
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
                            <input name="CIF" type="text" value="{{ $company->CIF }}" /><br />
                            @error('CIF')
                            <span class="validate-error">{{ $message }}</span><br />
                            @enderror
                        </div>

                        <div>
                            <label for="companyName">Nombre Empresa:</label><br />
                            <input name="companyName" type="text" value="{{ $company->company_name }}" /><br />
                            @error('companyName')
                            <span class="validate-error">{{ $message }}</span><br />
                            @enderror
                        </div>

                        <div>
                            <label for="web">Web:</label><br />
                            <input name="web" type="text" value="{{ $company->web }}" /><br />
                            @error('web')
                            <span class="validate-error">{{ $message }}</span><br />
                            @enderror
                        </div>

                        <div>
                            <label for="address">Dirección:</label><br />
                            <input name="address" type="text" value="{{ $company->address }}" /><br />
                            @error('address')
                            <span class="validate-error">{{ $message }}</span><br />
                            @enderror
                        </div>

                        <div>
                            <label for="CP">CP:</label><br />
                            <input name="CP" type="text" value="{{ $company->CP }}" /><br />
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

                    <button type="submit" class="btn btn-default btn-primary">Editar</button>
                </fieldset>
            </form>
            <a href="{{ route('company.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
        </div>
    </div>
@endsection

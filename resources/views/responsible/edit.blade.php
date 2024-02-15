@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ route('responsible.update', ['responsible' => $responsible->id]) }}">
        @csrf
            @method('PUT')
            <fieldset>
                <legend>Editar Responsable</legend>

                <div class="form-group">
                    <label class="col-md-4 control-label">Nombre</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $responsible->name }}"
                               autocomplete="name" autofocus>
                        @error('name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Apellido</label>
                    <div class="col-md-6">
                        <input id="surname" type="text" class="form-control" name="surname"
                               value="{{ $responsible->surname }}" autocomplete="surname">
                        @error('surname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Email</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ $responsible->email }}" autocomplete="email">
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Contraseña</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password"
                               autocomplete="new-password">
                        @error('password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="responsible_id" value="{{ $responsible->id }}">
                <div>
                    <input type="hidden" name="rol" value="RESP" />
                </div>

                <div class="form-group">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
                <br>
                <div class="col-md-6 offset-md-4">
                    <a href="{{ route('responsible.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
                </div>

            </fieldset>
        </form>
    </div>
@endsection

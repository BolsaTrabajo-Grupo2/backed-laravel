@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ route('responsible.store') }}">
            @csrf
            <fieldset>
                <legend>Crear Nuevo Responsable</legend>

                <div class="form-group">
                    <label class="col-md-4 control-label">Nombre</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Apellido</label>
                    <div class="col-md-6">
                        <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autocomplete="surname">
                        @error('surname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Email</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Contraseña</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <input type="hidden" name="rol" value="RESP" />
                </div>

                <div class="form-group">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Crear Responsable
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@endsection

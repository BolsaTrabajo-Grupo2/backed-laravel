@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<div class="row">
    <form method="POST" action="{{ route('updateResponsible', $cycle->id) }}">
        @csrf
        @method('PUT')
        <fieldset>
            <legend>Cambiar responsable</legend>

            <div class="form-group">
                <label for="responsible">Selecciona el nombre del responsable:</label><br />
                <select name="responsible" id="responsible" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($responsibles as $responsible)
                        <option value="{{ $responsible->id }}" @if($responsible->id == $cycle->id_responsible) selected @endif>
                            {{ $responsible->name }} {{$responsible->surname}}
                        </option>
                    @endforeach
                </select>
                @error('responsible')
                <span class="validate-error">{{ $message }}</span>
                @enderror
            </div>
            <br/>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </fieldset>
        <a href="{{ route('cycles.index') }}" class="btn btn-primary mb-3">Volver a la lista</a>
    </form>
</div>
</body>
</html>
@endsection

@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(to right, #0e1a4f, #a0ffd0);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 6px;
        }

        button {
            background: #00c2ff;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #0099cc;
        }

        .volver {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #fff;
        }

        .volver:hover {
            text-decoration: underline;
        }

        .error {
            color: #ff7b7b;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
    </style>

    <h1>✏️ Editar Estación</h1>

    <form method="POST" action="{{ route('estacions.update', $estacion->EstID) }}">
        @csrf
        @method('PUT')

        <label for="EstNombre">Nombre de la estación:</label>
        <input type="text" name="EstNombre" value="{{ old('EstNombre', $estacion->EstNombre) }}" required>
        @error('EstNombre') <div class="error">{{ $message }}</div> @enderror

        <label for="EstUbicacion">Ubicación:</label>
        <input type="text" name="EstUbicacion" value="{{ old('EstUbicacion', $estacion->EstUbicacion) }}" required>
        @error('EstUbicacion') <div class="error">{{ $message }}</div> @enderror

        <button type="submit">💾 Guardar cambios</button>
    </form>

    <a class="volver" href="{{ route('estacions.index') }}">⬅️ Volver al listado</a>
@endsection

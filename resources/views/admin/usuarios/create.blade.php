@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(to right, #0e1a4f, #a0ffd0);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
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

    <h2>➕ Crear nuevo Administrador</h2>

    <form method="POST" action="{{ route('admin.usuarios.store') }}">
        @csrf

        <label for="UsuNombres">Nombres:</label>
        <input type="text" name="UsuNombres" value="{{ old('UsuNombres') }}" required>
        @error('UsuNombres') <div class="error">{{ $message }}</div> @enderror

        <label for="UsuApellidos">Apellidos:</label>
        <input type="text" name="UsuApellidos" value="{{ old('UsuApellidos') }}" required>
        @error('UsuApellidos') <div class="error">{{ $message }}</div> @enderror

        <label for="UsuCorreo">Correo electrónico:</label>
        <input type="email" name="UsuCorreo" value="{{ old('UsuCorreo') }}" required>
        @error('UsuCorreo') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">💾 Guardar administrador</button>
    </form>

    <a class="volver" href="{{ route('admin.usuarios.index') }}">⬅️ Volver a la lista</a>
@endsection

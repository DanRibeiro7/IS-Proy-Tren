@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(to right, #0e1a4f, #a0ffd0);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        button {
            background: #00c2ff;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
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
            background-color: rgba(255, 0, 0, 0.1);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>

    <div class="form-container">
        <h2>🔐 Iniciar Sesión</h2>

        @if ($errors->has('error'))
            <div class="error">{{ $errors->first('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="UsuCorreo">Correo electrónico</label>
            <input type="email" name="UsuCorreo" id="UsuCorreo" value="{{ old('UsuCorreo') }}" required>

            <label for="UsuPassword">Contraseña</label>
            <input type="password" name="UsuPassword" id="UsuPassword" required>

            <button type="submit">Ingresar</button>
        </form>

        <a class="volver" href="{{ url()->previous() }}">⬅️ Volver</a>
    </div>
@endsection

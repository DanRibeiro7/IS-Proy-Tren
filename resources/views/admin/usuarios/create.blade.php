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
    <h2>➕ Registrar Nuevo Cliente</h2>

    @if ($errors->any())
        <div class="error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.clientes.store') }}">
        @csrf

        <label for="UsuNombres">Nombres</label>
        <input type="text" name="UsuNombres" id="UsuNombres" value="{{ old('UsuNombres') }}"
               required maxlength="100" title="Solo letras y espacios">

        <label for="UsuApellidos">Apellidos</label>
        <input type="text" name="UsuApellidos" id="UsuApellidos" value="{{ old('UsuApellidos') }}"
               required maxlength="100" title="Solo letras y espacios">

        <label for="UsuCorreo">Correo electrónico</label>
        <input type="email" name="UsuCorreo" id="UsuCorreo" value="{{ old('UsuCorreo') }}" required>

        <label for="UsuNumero">Número de contacto</label>
        <input type="text" name="UsuNumero" id="UsuNumero" value="{{ old('UsuNumero') }}"
               required maxlength="9" title="Debe contener 9 dígitos numéricos">

        <label for="UsuPassword">Contraseña</label>
        <input type="password" name="UsuPassword" id="UsuPassword" required>

        <label for="UsuPassword_confirmation">Confirmar contraseña</label>
        <input type="password" name="UsuPassword_confirmation" id="UsuPassword_confirmation" required>

        <button type="submit">Registrar Cliente</button>
    </form>

    <a class="volver" href="{{ route('admin.clientes.index') }}">⬅️ Volver</a>
</div>

<script>
    // Solo letras y espacios
    const soloLetras = (e) => {
        const char = String.fromCharCode(e.which);
        if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(char)) {
            e.preventDefault();
        }
    };

    // Solo números (0–9)
    const soloNumeros = (e) => {
        const char = String.fromCharCode(e.which);
        if (!/[0-9]/.test(char)) {
            e.preventDefault();
        }
    };

    document.getElementById('UsuNombres').addEventListener('keypress', soloLetras);
    document.getElementById('UsuApellidos').addEventListener('keypress', soloLetras);
    document.getElementById('UsuNumero').addEventListener('keypress', soloNumeros);
</script>
@endsection

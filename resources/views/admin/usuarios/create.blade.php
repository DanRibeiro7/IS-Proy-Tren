@extends('layouts.app')

@section('content')
    <h2>➕ Crear Nuevo Administrador</h2>

    @if ($errors->any())
        <div style="color:red;">
            <strong>Errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf

        <div>
            <label for="UsuNombres">Nombres:</label>
            <input type="text" name="UsuNombres" required>
        </div>

        <div>
            <label for="UsuApellidos">Apellidos:</label>
            <input type="text" name="UsuApellidos" required>
        </div>

        <div>
            <label for="UsuCorreo">Correo:</label>
            <input type="email" name="UsuCorreo" required>
        </div>
         <div>
            <label for="UsuNumero">Correo:</label>
            <input type="numero" name="UsuNumero" required>
        </div>

        <div>
            <label for="Usupassword">Contraseña:</label>
            <input type="password" name="UsuPassword" required>
        </div>
<div>
    <label for="UsuPassword_confirmation">Confirmar contraseña:</label>
    <input type="password" name="UsuPassword_confirmation" required>
</div>
        <button type="submit">✅ Guardar Administrador</button>
    </form>

    <br>
    <a href="{{ route('admin.usuarios.index') }}">⬅️ Volver a la lista de usuarios</a>
@endsection

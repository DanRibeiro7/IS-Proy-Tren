@extends('layouts.app')

@section('content')
    <h2>✏️ Editar Administrador</h2>

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

    <form action="{{ route('admin.usuarios.update', $usuario->UsuID) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="UsuNombres">Nombres:</label>
            <input type="text" name="UsuNombres" value="{{ old('UsuNombres', $usuario->UsuNombres) }}" required>
        </div>

        <div>
            <label for="UsuApellidos">Apellidos:</label>
            <input type="text" name="UsuApellidos" value="{{ old('UsuApellidos', $usuario->UsuApellidos) }}" required>
        </div>

        <div>
            <label for="UsuCorreo">Correo:</label>
            <input type="email" name="UsuCorreo" value="{{ old('UsuCorreo', $usuario->UsuCorreo) }}" required>
        </div>

        <div>
            <label for="password">Contraseña (dejar en blanco si no se desea cambiar):</label>
            <input type="password" name="password">
        </div>

        <button type="submit">💾 Actualizar</button>
    </form>

    <br>
    <a href="{{ route('admin.usuarios.index') }}">⬅️ Volver a la lista de usuarios</a>
@endsection

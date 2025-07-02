@extends('layouts.app')

@section('content')
    <h2>👥 Gestión de Usuarios</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    {{-- Administradores --}}
    <h3>🛡️ Administradores</h3>
    <a href="{{ route('admin.usuarios.create') }}">➕ Crear nuevo administrador</a>

    @if($admins->isEmpty())
        <p>No hay administradores registrados.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
            @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->UsuID }}</td>
                    <td>{{ $admin->UsuNombres }} {{ $admin->UsuApellidos }}</td>
                    <td>{{ $admin->UsuCorreo }}</td>
                    <td>
                        <a href="{{ route('admin.usuarios.edit', $admin->UsuID) }}">✏️ Editar</a>
                        <form action="{{ route('admin.usuarios.destroy', $admin->UsuID) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este administrador?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red;">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    {{-- Clientes --}}
    <h3>👤 Clientes</h3>

    @if($clientes->isEmpty())
        <p>No hay clientes registrados.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Correo</th>
            </tr>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->UsuID }}</td>
                    <td>{{ $cliente->UsuNombres }} {{ $cliente->UsuApellidos }}</td>
                    <td>{{ $cliente->UsuCorreo }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <br>
    <a href="{{ route('admin.dashboard') }}">⬅️ Volver al panel</a>
@endsection

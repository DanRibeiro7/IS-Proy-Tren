@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(to right, #0e1a4f, #a0ffd0);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        h2, h3 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #fff;
        }

        th {
            background: rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }

        td {
            background: rgba(255, 255, 255, 0.08);
        }

        tr:nth-child(even) td {
            background: rgba(255, 255, 255, 0.1);
        }

        a, button {
            color: #00f3ff;
            text-decoration: none;
            font-weight: bold;
            background: none;
            border: none;
            cursor: pointer;
        }

        button:hover, a:hover {
            text-decoration: underline;
        }

        .crear-link {
            display: block;
            width: fit-content;
            margin: 10px auto;
            background: #00c2ff;
            padding: 8px 14px;
            border-radius: 8px;
        }

        .volver {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #fff;
        }

        .volver:hover {
            text-decoration: underline;
        }

        .success {
            color: #00ff80;
            text-align: center;
            font-weight: bold;
        }
    </style>

    <h2>👥 Gestión de Usuarios</h2>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    {{-- Administradores --}}
    <h3>🛡️ Administradores</h3>
    <a href="{{ route('admin.usuarios.create') }}" class="crear-link">➕ Crear nuevo administrador</a>

    @if($admins->isEmpty())
        <p style="text-align:center;">No hay administradores registrados.</p>
    @else
        <table>
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
                            <button type="submit">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    {{-- Clientes --}}
    <h3>👤 Clientes</h3>
    @if($clientes->isEmpty())
        <p style="text-align:center;">No hay clientes registrados.</p>
    @else
        <table>
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

    <a class="volver" href="{{ route('admin.dashboard') }}">⬅️ Volver al panel</a>
@endsection

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

        .crear-link {
            display: block;
            width: fit-content;
            margin: 20px auto;
            background: #00c2ff;
            padding: 10px 18px;
            border-radius: 8px;
            text-align: center;
            color: white;
            text-decoration: none;
            font-weight: bold;
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

        .volver {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #fff;
        }

        .volver:hover {
            text-decoration: underline;
        }
    </style>

    <h1>🚉 Listado de Estaciones</h1>

    

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estaciones as $estacion)
                <tr>
                    <td>{{ $estacion->EstNombre }}</td>
                    <td>{{ $estacion->EstUbicacion }}</td>
                    <td>
                        <a href="{{ route('estacions.edit', $estacion->EstID) }}">✏️ Editar</a>
                        |
                        <form action="{{ route('estacions.destroy', $estacion->EstID) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta estación?');">
                            @csrf
                            @method('DELETE')
                            
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="volver" href="{{ route('admin.dashboard') }}">⬅️ Volver al panel</a>
@endsection

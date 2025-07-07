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

        table {
            width: 95%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-weight: bold;
        }

        td {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        tr:nth-child(even) td {
            background-color: rgba(255, 255, 255, 0.08);
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

        .anulado {
            color: red;
            font-weight: bold;
        }
    </style>

    <h2>📜 Historial de Boletos Emitidos</h2>

    @if($boletos->isEmpty())
        <p style="text-align:center;">No se han registrado boletos aún.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Fecha de Compra</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boletos as $boleto)
                    <tr>
                        <td>{{ $boleto->BolID }}</td>
                        <td>{{ $boleto->usuario->UsuNombres }} {{ $boleto->usuario->UsuApellidos }}</td>
                        <td>{{ $boleto->estacion_origen->EstNombre }}</td>
                        <td>{{ $boleto->estacion_destino->EstNombre }}</td>
                        <td>{{ \Carbon\Carbon::

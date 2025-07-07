@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(to right, #0e1a4f, #a0ffd0);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .contenedor {
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1em;
            margin-top: 10px;
        }

        .enlaces a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background: #00c2ff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .enlaces a:hover {
            background: #009ec2;
        }
    </style>

    <div class="contenedor">
        <h2>👋 Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar todo el sistema de trenes turísticos.</p>

       
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Bienvenido Cliente')

@section('content')
    <p>Usuario autenticado: {{ auth()->user()->UsuNombres }}</p>
    <p>Rol: {{ auth()->user()->UsuTipoUsuario }}</p>

    <h1>Bienvenido Cliente - Tren Turístico</h1>
    <p>Explora estaciones, destinos turísticos y compra tus boletos aquí.</p>

    <a href="{{ route('cliente.linea_tren') }}">🚆 Ver Línea del Tren</a>
@endsection

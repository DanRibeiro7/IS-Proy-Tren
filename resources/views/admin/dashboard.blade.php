@extends('layouts.app')

@section('title', 'Panel Administrador')

@section('content')
<p>Usuario autenticado: {{ auth()->user()->UsuNombres }}</p>
<p>Rol: {{ auth()->user()->UsuTipoUsuario }}</p>

    <h1>Bienvenido Administrador</h1>
    <a href="{{ route('admin.linea') }}">🚆 Ver Línea del Tren</a>
@endsection

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tren Turístico')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        nav {
            background: #3490dc;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <nav>
        @auth
            @if(auth()->user()->UsuTipoUsuario === 'cliente')
                <a href="{{ route('cliente.dashboard') }}">Inicio</a>
                <a href="{{ route('cliente.linea') }}">Ver Estaciones</a>
               
                
            @elseif(auth()->user()->UsuTipoUsuario === 'admin')
                <a href="{{ route('admin.dashboard') }}">Panel Admin</a>
                <a href="{{ route('admin.linea') }}">Ver Línea de Tren</a>
                <a href="{{ route('estacions.index') }}">Estaciones</a>
                <a href="{{ route('destinos.index') }}">Destinos Turísticos</a>
                <a href="{{ route('climas.index') }}">Climas</a>
            @endif

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar Sesión
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>
        @endauth
    </nav>

    <main style="padding: 20px;">
        @yield('content')
    </main>

</body>
</html>

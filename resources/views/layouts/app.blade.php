<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Tren Turístico')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ✅ Estilo base con fondo gradiente y navegación elegante --}}
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0e1a4f, #a0ffd0);
            color: #fff;
        }

        nav {
            background: #2c3e50;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 30px;
        }
    </style>

    {{-- ✅ Permitir que vistas agreguen estilos propios sin romper --}}
    @stack('styles')
</head>
<body>

    <nav>
        @auth
            @if(auth()->user()->UsuTipoUsuario === 'cliente')
                <a href="{{ route('cliente.dashboard') }}">🏠 Inicio</a>
                <a href="{{ route('cliente.linea_tren') }}">🚉 Estaciones</a>
                <a href="{{ route('cliente.historial') }}">📋 Mis Boletos</a>
            @elseif(auth()->user()->UsuTipoUsuario === 'admin')
                <a href="{{ route('admin.dashboard') }}">📊 Panel Admin</a>
                <a href="{{ route('admin.usuarios.index') }}">👥 Gestionar Usuarios</a>
                <a href="{{ route('admin.linea') }}">🚆 Línea de Tren</a>
                <a href="{{ route('estacions.index') }}">🗺️ Estaciones</a>
                <a href="{{ route('destinos.index') }}">🏞️ Destinos Turísticos</a>
                <a href="{{ route('climas.index') }}">🌤️ Climas</a>
                <a href="{{ route('admin.boletos.historial') }}">📈 Reportes</a> 
            @endif

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                🚪 Cerrar Sesión
            </a>

            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- ✅ Permitir agregar scripts personalizados por vista --}}
    @stack('scripts')

</body>
</html>

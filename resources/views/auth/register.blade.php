<!DOCTYPE html>
<html>
<head>
    <title>Registro de Cliente</title>
</head>
<body>
    <h2>Registro de Cliente</h2>

    @if ($errors->any())
        <div>
            <ul style="color:red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <label>Nombres:</label><br>
        <input type="text" name="UsuNombres" value="{{ old('UsuNombres') }}"><br><br>

        <label>Apellidos:</label><br>
        <input type="text" name="UsuApellidos" value="{{ old('UsuApellidos') }}"><br><br>

        <label>Correo:</label><br>
        <input type="email" name="UsuCorreo" value="{{ old('UsuCorreo') }}"><br><br>

        <label>Número de teléfono:</label><br>
        <input type="text" name="UsuNumero" value="{{ old('UsuNumero') }}"><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="UsuPassword"><br><br>

        <label>Confirmar Contraseña:</label><br>
        <input type="password" name="UsuPassword_confirmation"><br><br>

        {{-- Campo oculto para tipo de usuario --}}
        <input type="hidden" name="UsuTipoUsuario" value="cliente">

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
</body>
</html>

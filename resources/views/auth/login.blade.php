<form method="POST" action="{{ route('login') }}">
    @csrf

    @if ($errors->has('error'))
        <p style="color:red;">{{ $errors->first('error') }}</p>
    @endif

    <input type="email" name="UsuCorreo" placeholder="Correo" required value="{{ old('UsuCorreo') }}">
    <input type="password" name="UsuPassword" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
</form>

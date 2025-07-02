<form method="POST" action="{{ route('login') }}" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
    @csrf

    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Iniciar Sesión</h2>

    @if ($errors->has('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="mb-4">
        <label for="UsuCorreo" class="block text-gray-700 mb-1">Correo electrónico</label>
        <input type="email" name="UsuCorreo" id="UsuCorreo" placeholder="Correo" required
            value="{{ old('UsuCorreo') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-6">
        <label for="UsuPassword" class="block text-gray-700 mb-1">Contraseña</label>
        <input type="password" name="UsuPassword" id="UsuPassword" placeholder="Contraseña" required
            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
        Ingresar
    </button>
</form>
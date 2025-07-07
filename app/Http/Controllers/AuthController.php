<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
    {
        $credentials = $request->only('UsuCorreo', 'UsuPassword');

        $usuario = Usuario::where('UsuCorreo', $credentials['UsuCorreo'])->first();

      if ($usuario && Hash::check($credentials['UsuPassword'], $usuario->UsuPassword)) {
    Auth::login($usuario);
    
   return redirect()->route($usuario->UsuTipoUsuario === 'admin' ? 'admin.dashboard' : 'cliente.dashboard');

}
    return back()->withInput()->withErrors([
        'error' => 'Correo o contraseña incorrectos',
    ]);
    }




    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function mostrarRegistro()
{
    return view('auth.register');
}

public function registrar(Request $request)
{
  $request->validate([
    'UsuNombres' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255'],
    'UsuApellidos' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255'],
    'UsuCorreo' => ['required', 'email', 'unique:usuario,UsuCorreo'],
    'UsuNumero' => ['required', 'regex:/^[1-9]+$/', 'max:20'],
    'UsuPassword' => ['required', 'string', 'min:8', 'confirmed'],
]);


    $usuario = Usuario::create([
            'UsuNombres' => $request->UsuNombres,
        'UsuApellidos' => $request->UsuApellidos,
        'UsuCorreo' => $request->UsuCorreo,
        'UsuNumero' => $request->UsuNumero,
        'UsuPassword' => bcrypt($request->UsuPassword),
        'UsuTipoUsuario' => 'cliente', // o 'admin' si es registro de admin
    ]);

    Auth::login($usuario);

    return redirect()->route('login')->with('success', 'Registro exitoso. Puedes iniciar sesión.');
}
}

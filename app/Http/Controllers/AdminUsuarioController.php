<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminUsuarioController extends Controller
{
 public function index()
{
    $clientes = Usuario::where('UsuTipoUsuario', 'cliente')->get();
    $admins = Usuario::where('UsuTipoUsuario', 'admin')->get();

    return view('admin.usuarios.index', compact('clientes', 'admins'));
}

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'UsuNombres' => 'required|string|max:100',
            'UsuApellidos' => 'required|string|max:100',
            'UsuCorreo' => 'required|email|unique:usuario,UsuCorreo',
            'UsuNumero' => 'nullable|string|max:20',
            'UsuPassword' => 'required|string|min:6|confirmed',
        ]);

        Usuario::create([
            'UsuNombres' => $request->UsuNombres,
            'UsuApellidos' => $request->UsuApellidos,
            'UsuCorreo' => $request->UsuCorreo,
            'UsuNumero' => $request->UsuNumero,
            'UsuPassword' => Hash::make($request->UsuPassword),
            'UsuTipoUsuario' => 'admin',
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Administrador creado exitosamente.');
    }
    public function edit($id)
{
    $usuario = Usuario::where('UsuID', $id)
                      ->where('UsuTipoUsuario', 'admin')
                      ->firstOrFail();

    return view('admin.usuarios.edit', compact('usuario'));
}
public function update(Request $request, $id)
{
    $usuario = Usuario::where('UsuID', $id)
                      ->where('UsuTipoUsuario', 'admin')
                      ->firstOrFail();

    $request->validate([
        'UsuNombres' => 'required|string|max:100',
        'UsuApellidos' => 'required|string|max:100',
        'UsuCorreo' => 'required|email|unique:usuario,UsuCorreo,' . $usuario->UsuID . ',UsuID',
        'password' => 'nullable|min:6',
    ]);

    $usuario->UsuNombres = $request->UsuNombres;
    $usuario->UsuApellidos = $request->UsuApellidos;
    $usuario->UsuCorreo = $request->UsuCorreo;

   if ($request->filled('password')) {
    $usuario->UsuPassword = Hash::make($request->password);
}


    $usuario->save();

    return redirect()->route('admin.usuarios.index')->with('success', '✅ Administrador actualizado correctamente.');
}
public function destroy($id)
{
    $usuario = Usuario::where('UsuID', $id)
                      ->where('UsuTipoUsuario', 'admin')
                      ->firstOrFail();

    $usuario->delete();

    return redirect()->route('admin.usuarios.index')->with('success', '🗑️ Administrador eliminado correctamente.');
}


}

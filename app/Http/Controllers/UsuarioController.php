<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'UsuNombres' => 'required',
            'UsuApellidos' => 'required',
            'UsuCorreo' => 'required|email|unique:usuario,UsuCorreo',
            'UsuNumero' => 'required',
            'UsuPassword' => 'required',
            'UsuTipoUsuario' => 'required',
        ]);

        Usuario::create($request->all());

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'UsuNombres' => 'required',
            'UsuApellidos' => 'required',
            'UsuCorreo' => 'required|email|unique:usuario,UsuCorreo,' . $usuario->UsuID . ',UsuID',
            'UsuNumero' => 'required',
            'UsuTipoUsuario' => 'required',
        ]);

        $usuario->update($request->all());

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}


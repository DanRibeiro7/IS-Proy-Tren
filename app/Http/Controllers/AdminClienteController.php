<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminClienteController extends Controller
{
    public function index()
    {
        $clientes = Usuario::where('UsuTipoUsuario', 'cliente')->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'UsuNombres' => 'required|regex:/^[\pL\s]+$/u|max:100',
            'UsuApellidos' => 'required|regex:/^[\pL\s]+$/u|max:100',
            'UsuCorreo' => 'required|email|unique:usuario,UsuCorreo',
            'UsuNumero' => 'required|regex:/^[1-9][0-9]*$/|max:20',
            'UsuPassword' => 'required|min:6|confirmed',
        ]);

        Usuario::create([
            'UsuNombres' => $request->UsuNombres,
            'UsuApellidos' => $request->UsuApellidos,
            'UsuCorreo' => $request->UsuCorreo,
            'UsuNumero' => $request->UsuNumero,
            'UsuPassword' => Hash::make($request->UsuPassword),
            'UsuTipoUsuario' => 'cliente',
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit($id)
    {
        $cliente = Usuario::where('UsuID', $id)
                          ->where('UsuTipoUsuario', 'cliente')
                          ->firstOrFail();

        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Usuario::where('UsuID', $id)
                          ->where('UsuTipoUsuario', 'cliente')
                          ->firstOrFail();

        $request->validate([
            'UsuNombres' => 'required|regex:/^[\pL\s]+$/u|max:100',
            'UsuApellidos' => 'required|regex:/^[\pL\s]+$/u|max:100',
            'UsuCorreo' => 'required|email|unique:usuario,UsuCorreo,' . $cliente->UsuID . ',UsuID',
            'UsuNumero' => 'required|regex:/^[1-9][0-9]*$/|max:20',
            'UsuPassword' => 'nullable|min:6',
        ]);

        $cliente->UsuNombres = $request->UsuNombres;
        $cliente->UsuApellidos = $request->UsuApellidos;
        $cliente->UsuCorreo = $request->UsuCorreo;
        $cliente->UsuNumero = $request->UsuNumero;

        if ($request->filled('UsuPassword')) {
            $cliente->UsuPassword = Hash::make($request->UsuPassword);
        }

        $cliente->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $cliente = Usuario::where('UsuID', $id)
                          ->where('UsuTipoUsuario', 'cliente')
                          ->firstOrFail();

        $cliente->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Cliente eliminado correctamente.');
    }
}

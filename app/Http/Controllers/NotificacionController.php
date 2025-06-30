<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::with('usuario')->get();
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        return view('notificaciones.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'UsuID' => 'required|exists:usuario,UsuID',
            'NotTipo' => 'required|string',
            'NotMensaje' => 'required|string',
            'NotEnviada' => 'required|boolean',
            'NotFechaEnvio' => 'required|date',
        ]);

        Notificacion::create($request->all());

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
    }

    public function edit($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $usuarios = Usuario::all();
        return view('notificaciones.edit', compact('notificacion', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $notificacion = Notificacion::findOrFail($id);

        $request->validate([
            'UsuID' => 'required|exists:usuario,UsuID',
            'NotTipo' => 'required|string',
            'NotMensaje' => 'required|string',
            'NotEnviada' => 'required|boolean',
            'NotFechaEnvio' => 'required|date',
        ]);

        $notificacion->update($request->all());

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();

        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada correctamente.');
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\DestinoTuristicoController;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\TrenPosicionController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('portada');
})->name('portada');

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'mostrarRegistro'])->name('register');
Route::post('/register', [AuthController::class, 'registrar']);

// API para la posición del tren (para JavaScript)
Route::get('/api/tren-posicion', [TrenPosicionController::class, 'estadoActual']);
Route::get('/api/tiempo-espera/{estacion_id}', [TrenPosicionController::class, 'tiempoEspera']);



/*
|--------------------------------------------------------------------------
| Rutas para Clientes (con middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'esCliente'])->prefix('cliente')->group(function () {
    Route::get('/', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');

    // Línea del tren
    Route::get('/linea', [ClienteController::class, 'lineaEstaciones'])->name('cliente.linea_tren');

    // Detalles de estación (JSON)
    Route::get('/estacion/{id}', [ClienteController::class, 'verDetallesEstacion'])->name('cliente.estacion.detalle');

    // Selección de origen y destino
    Route::get('/seleccionar-viaje', [ClienteController::class, 'seleccionarViaje'])->name('cliente.comprar_boleto');

    // Guardar boleto
    Route::post('/comprar-boleto', [BoletoController::class, 'store'])->name('boleto.store');

    // Ver boleto
    Route::get('/boleto/{id}', [ClienteController::class, 'verBoleto'])->name('cliente.ver_boleto');
    Route::get('/historial-boletos', [ClienteController::class, 'historialBoletos'])->name('cliente.historial');
Route::put('/cliente/boletos/{id}/anular', [ClienteController::class, 'anularBoleto'])->name('cliente.anular_boleto');

    Route::get('/cliente/preferencias', [ClienteController::class, 'mostrarFormularioPreferencias'])->name('cliente.preferencias.form');
    Route::post('/cliente/preferencias', [ClienteController::class, 'guardarPreferencias'])->name('cliente.preferencias.guardar');
    Route::get('/cliente/boletos/{id}/pdf', [ClienteController::class, 'descargarPDF'])->name('cliente.descargar_pdf');

});


/*
|--------------------------------------------------------------------------
| Rutas para Administrador (con middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'esAdmin'])->prefix('admin')->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth', 'esAdmin');

   
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Línea del tren para admin
    Route::get('/linea', [AdminController::class, 'linea'])->name('admin.linea');

    // Recursos
    Route::resource('estacions', EstacionController::class);
    Route::resource('destinos', DestinoTuristicoController::class);
    Route::resource('climas', ClimaController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('rutas', RutaController::class);
  
    Route::resource('admin/clientes', AdminClienteController::class)
    ->names([
        'index' => 'admin.clientes.index',
        'create' => 'admin.clientes.create',
        'store' => 'admin.clientes.store',
        'edit' => 'admin.clientes.edit',
        'update' => 'admin.clientes.update',
        'destroy' => 'admin.clientes.destroy',
    ])
    ->middleware('auth'); // O usa tu middleware EsAdmin

    
 Route::get('/', [AdminUsuarioController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/crear', [AdminUsuarioController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/', [AdminUsuarioController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/{id}/editar', [AdminUsuarioController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/{id}', [AdminUsuarioController::class, 'update'])->name('admin.usuarios.update');
    Route::delete('/{id}', [AdminUsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');
     Route::get('/admin/boletos/historial', [\App\Http\Controllers\AdminBoletoController::class, 'historial'])->name('admin.boletos.historial');
         Route::get('/boletos/{id}', [AdminController::class, 'verBoleto'])->name('admin.ver_boleto');
    Route::put('/boletos/{id}/anular', [AdminController::class, 'anularBoleto'])->name('admin.anular_boleto');
    Route::get('/boletos/{id}/pdf', [AdminController::class, 'generarPDF'])->name('admin.boleto_pdf');

});

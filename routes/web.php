<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\DestinoTuristicoController;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\LineaTrenController;
use App\Http\Controllers\TrenPosicionController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('portada');
})->name('portada');
 // página principal
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'mostrarRegistro'])->name('register');
Route::post('/register', [AuthController::class, 'registrar']);


// API Tren posición (por JS)
Route::get('/api/tren-posicion', [TrenPosicionController::class, 'estadoActual']);


/*
|--------------------------------------------------------------------------
| Rutas para Clientes (con middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'esCliente'])->prefix('cliente')->group(function () {
    Route::get('/', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');
     Route::get('/linea', [ClienteController::class, 'linea'])->name('cliente.linea');
    Route::get('/linea-tren', [ClienteController::class, 'lineaEstaciones'])->name('cliente.linea');
    Route::get('/estacion/{id}', [ClienteController::class, 'verDetallesEstacion'])->name('cliente.estacion.detalle');
    Route::get('/seleccionar-viaje', [ClienteController::class, 'seleccionarViaje'])->name('cliente.seleccionar');
    Route::post('/comprar-boleto', [BoletoController::class, 'store'])->name('boleto.store');
    Route::get('/boleto/{id}', [ClienteController::class, 'verBoleto'])->name('cliente.ver_boleto');
});


/*
|--------------------------------------------------------------------------
| Rutas para Admin (con middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'esAdmin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/linea', [AdminController::class, 'linea'])->name('admin.linea');

    Route::resource('estacions', EstacionController::class);
    Route::resource('destinos', DestinoTuristicoController::class);
    Route::resource('climas', ClimaController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('rutas', RutaController::class);
});


/*
|--------------------------------------------------------------------------
| Otras rutas generales si se necesitan
|--------------------------------------------------------------------------
*/




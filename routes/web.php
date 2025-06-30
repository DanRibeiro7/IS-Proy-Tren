<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\DestinoTuristicoController;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\BoletoController;

//Route::get('/', function () {
  //  return view('welcome');
//});

// Rutas del recurso Estacion

Route::get('/', [EstacionController::class, 'index']);
Route::resource('estacions', EstacionController::class); // 👈 Esto registra todas las rutas RESTful

Route::resource('destinos', DestinoTuristicoController::class);

Route::resource('usuarios', UsuarioController::class);

Route::resource('rutas', RutaController::class);

Route::resource('climas', ClimaController::class);


Route::get('/linea-estaciones', [EstacionController::class, 'mostrarLinea'])->name('linea.estaciones');



Route::post('/boletos', [BoletoController::class, 'store'])->name('boletos.store');

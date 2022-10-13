<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PersonaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//LISTAR TODOS
Route::get('/personas', [PersonaController::class, 'getAll']);

//LISTAR ESPECIFICAMENTE
Route::get('/personas/{id}', [PersonaController::class, 'getItem']);

//INSERTAR
Route::post('/personas', [PersonaController::class, 'store']);

//ACTUALIZAR
Route::put('/personas/{id}', [PersonaController::class, 'updatePut']);

//BORRAR
Route::delete('/personas/{id}', [PersonaController::class, 'delete']);

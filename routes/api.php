<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PacienteController;
use App\Http\Controllers\API\AutenticarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::post('registro',[AutenticarController::class, 'registro']);
Route::post('acceso',[AutenticarController::class, 'acceso']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('cerrarsesion',[AutenticarController::class, 'cerrarSesion']);
    Route::get('pacientes', [PacienteController::class, 'index']);
    Route::post('pacientes', [PacienteController::class, 'store']);
    Route::get('pacientes/{paciente}', [PacienteController::class, 'show']);
    Route::put('pacientes/{paciente}',[PacienteController::class, 'update']);
    Route::delete('pacientes/{paciente}',[PacienteController::class, 'destroy']);
});


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolController;
use App\Models\Empleado;

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

Route::post('auth/login', [AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user-info', [EmpleadoController::class, 'getUserInfo']);
    Route::get('/user-information-total', [EmpleadoController::class, 'getUserInformationTotal']);
    Route::post('/registrar-asistencia', [AsistenciaController::class, 'registrarAsistencia']);
    Route::get('/empleados', [EmpleadoController::class, 'index']);
    Route::post('/empleados', [EmpleadoController::class, 'store']);
    Route::get('/buscar-empleados', [EmpleadoController::class, 'buscarEmpleados']);
    Route::get('/obtener-puestos', [PuestoController::class, 'obtenerPuestos']);
    Route::get('/obtener-roles', [RolController::class, 'index']);
    Route::get('auth/logout', [AuthController::class,'logout']);
    Route::put('/empleados/{id}', [EmpleadoController::class, 'update']);
    Route::put('/empleados/{id}/soft-delete', [EmpleadoController::class, 'softDelete']);
    Route::get('/roles', [EmpleadoController::class, 'getAllRoles']);
    Route::get('/empleado-role', [EmpleadoController::class, 'getEmpleadoRole']);
});
<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\CategoriaController;

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
Route::get('/test-token', [AuthController::class, 'testToken']);

Route::post('/login', [LoginController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
    Route::post('/login', [AuthController::class, 'login']); // Ruta para el inicio de sesión
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); // Retorna el usuario autenticado
});

/* Categoria*/

Route::middleware('auth:sanctum')->get('/categorias', [CategoriaController::class, 'index']);

Route::apiResource('categorias', CategoriaController::class);

/* Marca */

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/marcas', [MarcaController::class, 'index']);
    Route::post('/marcas', [MarcaController::class, 'store']);
    // Agrega otras rutas para editar y eliminar marcas si es necesario
});

Route::middleware('auth:sanctum')->get('/marcas', [MarcaController::class, 'index']);

/* Proveedores */

Route::middleware('auth:sanctum')->get('/proveedores', [ProveedoresController::class, 'index']);
Route::post('/proveedores', [ProveedoresController::class, 'store']);


/* Productos */

Route::middleware('auth:sanctum')->get('/productos', [ProductoController::class, 'index']);

/* Activity Log */

Route::middleware('auth:sanctum')->get('/activity', [ActivityController::class, 'index']);


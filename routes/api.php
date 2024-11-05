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

// Definición de rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categorias', [CategoriaController::class, 'index']); // Lista todas las categorías
    Route::post('/categorias', [CategoriaController::class, 'store']); // Crear nueva categoría

    Route::get('/categorias/{categoria}', [CategoriaController::class, 'show']); // Mostrar una categoría específica por ID
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']); // Actualizar una categoría específica por ID
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy']); // Eliminar una categoría específica por ID
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categorias', CategoriaController::class);
});


/* Marca */

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/marcas', [MarcaController::class, 'index']);
    Route::post('/marcas', [MarcaController::class, 'store']);
    Route::delete('/marcas', [MarcaController::class, 'destroy']);
    // Agrega otras rutas para editar y eliminar marcas si es necesario
});
Route::apiResource('marcas', MarcaController::class);
//Route::put('/marcas/{id}', [MarcaController::class, 'update'])->name('marcas.update');
Route::put('/marcas/{id}', [MarcaController::class, 'update']);


Route::middleware('auth:sanctum')->get('/marcas', [MarcaController::class, 'index']);

/* Proveedores */

Route::middleware('auth:sanctum')->group(function () {
    // Rutas para CRUD de proveedores usando apiResource
    Route::apiResource('proveedores', ProveedoresController::class);
});

// Si deseas tener un endpoint específico para obtener un proveedor sin apiResource
Route::get('/api/proveedor/{id}', [ProveedoresController::class, 'show'])->middleware('auth:sanctum');


/* Productos */

Route::middleware('auth:sanctum')->get('/productos', [ProductoController::class, 'index']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::delete('/productos', [ProductoController::class, 'destroy']);
Route::apiResource('productos', ProductoController::class);
Route::put('/productos/{id}', [ProductoController::class, 'update']);


/* Rutas para listar */

Route::get('/marcas', [MarcaController::class, 'index']);
Route::apiResource('productos', ProductoController::class);

Route::get('/categorias', [CategoriaController::class, 'index']);
Route::apiResource('categorias', CategoriaController::class);


Route::get('/proveedores', [ProveedoresController::class, 'index']);

/* Activity Log */

Route::middleware('auth:sanctum')->get('/activity', [ActivityController::class, 'index']);


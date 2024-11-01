<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedoresController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* Routes of Views */

Route::get('usuarios/productos', [UserController::class, 'showUserProducts'])->name('usuarios.productos');

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');


Route::resource('marcas', MarcaController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('productos', ProductoController::class);

Route::post('proveedores/{id}/assign-products', [ProveedoresController::class, 'assignProducts'])->name('proveedores.assignProducts');

Route::resource('proveedores', ProveedoresController::class);

Route::delete('/productos/{id}/delete', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');

Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
Route::resource('categorias', CategoriaController::class);

/* Categorias */
Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias.index');

Route::get('/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categorias.create');

Route::post('/categorias', [App\Http\Controllers\CategoriaController::class, 'store'])->name('categorias.store');

Route::put('/categorias/{categorias}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('categorias.update');

Route::get('/categorias/{id}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('categorias.form');

Route::delete('/categorias/{id}/delete', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categorias.destroy');



/* Productos */
Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');

Route::get('/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');

Route::post('/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');

Route::put('/productos/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');

Route::get('/productos/{id}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->name('productos.form');

Route::delete('/productos/{id}/delete', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');


/* Marcas */

Route::get('/marcas', [App\Http\Controllers\MarcaController::class, 'index'])->name('marcas.index');

Route::get('/marcas/create', [App\Http\Controllers\MarcaController::class, 'create'])->name('marcas.create');

Route::post('/marcas', [App\Http\Controllers\MarcaController::class, 'store'])->name('marcas.store');

Route::put('/marcas/{marca}', [App\Http\Controllers\MarcaController::class, 'update'])->name('marcas.update');

Route::get('/marcas/{id}/edit', [App\Http\Controllers\MarcaController::class, 'edit'])->name('marcas.edit');

Route::delete('/marcas/{id}/delete', [App\Http\Controllers\MarcaController::class, 'destroy'])->name('marcas.destroy');

/* Proveedores */

Route::get('/proveedores', [App\Http\Controllers\ProveedoresController::class, 'index'])->name('proveedores.index');

Route::get('/proveedores/create', [App\Http\Controllers\ProveedoresController::class, 'create'])->name('proveedores.create');

Route::post('/proveedores', [App\Http\Controllers\ProveedoresController::class, 'store'])->name('proveedores.store');

Route::put('/proveedores/{proveedores}', [App\Http\Controllers\ProveedoresController::class, 'update'])->name('proveedores.update');

Route::get('/proveedores/{id}/edit', [App\Http\Controllers\ProveedoresController::class, 'edit'])->name('proveedores.form');

Route::delete('/proveedores/{id}/delete', [App\Http\Controllers\ProveedoresController::class, 'destroy'])->name('proveedores.destroy');

/* Activity Log */

Route::get('/activity-log', [App\Http\Controllers\ActivityController::class, 'index'])->name('activity-log.index');

/* End Routes of Views */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

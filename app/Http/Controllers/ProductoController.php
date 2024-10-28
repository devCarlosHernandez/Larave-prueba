<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\User;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('marca', 'categoria')->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $marcas = Marca::all(); 
        $categorias = Categoria::all(); 
        $proveedores = Proveedores::all(); // Obtener todos los proveedores
        return view('productos.create', compact('marcas', 'categorias', 'proveedores'));
    }


    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'descripcion' => 'required',
        'precio' => 'required|numeric',
        'marca_id' => 'required|exists:marcas,id',
        'categoria_id' => 'nullable|exists:categorias,id',
        'proveedor_id' => 'required|array', // Cambia esto si solo aceptas un proveedor
        'proveedor_id.*' => 'exists:proveedores,id', // Validar que cada ID de proveedor exista
    ]);

    // Verificar si el producto ya existe
    $productoExistente = Producto::where('nombre', $request->nombre)
        ->where('marca_id', $request->marca_id)
        ->first();

    if ($productoExistente) {
        return back()->withErrors([
            'nombre' => 'Ya existe un producto con este nombre y marca.',
        ])->withInput();
    }

    // Crear el nuevo producto, excluyendo proveedor_id
    $productoData = $request->only(['nombre', 'descripcion', 'precio', 'marca_id', 'categoria_id']);
    $producto = Producto::create($productoData);

    // Asociar los proveedores al producto
    $producto->proveedores()->attach($request->proveedor_id);

    $userId = auth()->id(); // Obtener el ID del usuario autenticado
    $user = User::find($userId); // Encontrar al usuario
    $user->productos()->attach($producto->id); // Asociar el producto al usuario

    // Registrar la actividad
    activity()
        ->performedOn($producto) // Registrar la actividad en el nuevo producto creado
        ->causedBy(auth()->user()) // Usuario que realiza la acción
        ->log('Creó un nuevo producto: ' . $producto->nombre);

    return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
}


    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $proveedores = Proveedores::all();
        $productos = Producto::with('proveedores')->get();
        return view('productos.edit', compact('producto', 'marcas', 'categorias', 'proveedores'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'marca_id' => 'required|exists:marcas,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'proveedor_id' => 'required|array',
        ]);

        // Registrar la actividad antes de actualizar
        activity()
            ->performedOn($producto)
            ->causedBy(auth()->user())
            ->log('Actualizó el producto: ' . $producto->nombre);

        // Actualizar el producto
        $producto->update($request->only(['nombre', 'descripcion', 'precio', 'marca_id', 'categoria_id']));

        // Sincronizar la relación con los proveedores
        $producto->proveedores()->sync($request->proveedor_id);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }



    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        activity()
        ->performedOn($producto) 
        ->causedBy(auth()->user())
        ->log('Se eliminó el producto: ' . $producto->nombre);
        $producto->delete();
    
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
    

    
    
}


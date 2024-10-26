<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Categoria;

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
        return view('productos.create', compact('marcas', 'categorias'));
    }


    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'descripcion' => 'required',
        'precio' => 'required|numeric',
        'marca_id' => 'required|exists:marcas,id',
        'categoria_id' => 'nullable|exists:categorias,id',
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

    // Crear el nuevo producto
    $producto = Producto::create($request->all());

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
        return view('productos.edit', compact('producto', 'marcas', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'marca_id' => 'required|exists:marcas,id',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        activity()
        ->performedOn($producto) 
        ->causedBy(auth()->user())
        ->log('Actualizó el producto: ' . $producto->nombre);

        
        $producto->update($request->all());
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


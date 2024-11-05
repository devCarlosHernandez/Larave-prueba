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
        if (request()->expectsJson()) {
            // Obtener productos con marcas, categorías y proveedores
            $productos = Producto::with('marca', 'categoria', 'proveedores')->paginate(50);
            return response()->json($productos);
        }

        // Obtener productos para la vista en Laravel
        $productos = Producto::with('marca', 'categoria', 'proveedores')->get();
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


    public function show($id)
    {

        $producto = Producto::with('proveedores:id')->find($id);


        $producto->proveedor_id = $producto->proveedores->map->id->toArray();
        unset($producto->proveedores);

        return response()->json($producto);

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
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'marca_id' => 'required|exists:marcas,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'proveedor_id' => 'required|array',
        ]);

        // Actualizar solo los campos que han sido enviados en la solicitud
        $producto->update($request->only(['nombre', 'descripcion', 'precio', 'marca_id', 'categoria_id']));

        // Registrar la actividad
        activity()
            ->performedOn($producto)
            ->causedBy(auth()->user())
            ->log('Actualizó el producto: ' . $producto->nombre);

        // Sincronizar la relación con los proveedores
        $producto->proveedores()->sync($request->proveedor_id);

        // Devuelve una respuesta JSON si la solicitud espera JSON
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Producto actualizado correctamente.'], 200);
        }

        // Redirigir a la vista del índice con un mensaje si no es JSON
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id); // Buscar el producto o lanzar excepción

            activity()
                ->performedOn($producto)
                ->causedBy(auth()->user())
                ->log('Se eliminó el producto: ' . $producto->nombre);

            $producto->delete(); // Eliminar el producto

            // Verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Producto eliminado correctamente.'], 200);
            }

            // Si no espera JSON, redirecciona a la vista
            return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');

        } catch (\Exception $e) {
            // Si ocurre un error, verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Producto no encontrado.'], 404);
            }

            // Si no espera JSON, redirecciona a la vista con mensaje de error
            return redirect()->route('productos.index')->with('error', 'Producto no encontrado.');
        }
    }

}


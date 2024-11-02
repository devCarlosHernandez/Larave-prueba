<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MarcaController extends Controller
{
    public function index()
    {
        if (request()->expectsJson()) {
            return response()->json(Marca::all()); // Obtener todas las marcas sin paginación
        }

        $marcas = Marca::with('productos')->get(); // Asegúrate de usar 'marcas' en lugar de 'marca' para ser coherente
        return view('marcas.index', compact('marcas'));
    }


    public function create()
    {
        $productos = Producto::all();
        return view('marcas.form', compact('productos'));
    }



    public function store(Request $request)
    {
        // Validar los campos necesarios
        $request->validate([
            'nombre' => 'required|max:45',
            // Elimina producto_id si no es necesario
        ]);

        // Crear la nueva marca
        $marca = Marca::create($request->only('nombre'));

        // Registrar la actividad
        activity()
            ->performedOn($marca)
            ->causedBy(auth()->user())
            ->log('Creó una nueva marca: ' . $marca->nombre);

        // Si la solicitud espera JSON, retorna respuesta JSON
        if ($request->expectsJson()) {
            return response()->json(['mensaje' => 'Marca registrada', 'marca' => $marca], 201);
        }

        // Redireccionar y agregar mensaje a la sesión
        Session::flash('mensaje', 'Marca registrada');
        return redirect()->route('marcas.index')->with('mensaje', 'Marca registrada');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'producto_id' => 'required|string|max:255',  //Integer
        ]);


        $marca = Marca::findOrFail($id);

        $marca->update([
            'nombre' => $request->nombre,
            'producto_id' => $request->producto_id,
        ]);

        activity()
        ->performedOn($marca)
        ->causedBy(auth()->user())
        ->log('Actualizó la marca: ' . $marca->nombre);

        return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
    }

    public function show(Marca $marca)
    {
        return response()->json($marca);

        return view('marcas.show', compact('marcas'));
    }

    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        $productos = Producto::all();
        return view('marcas.edit', compact('marca', 'productos'));
    }


    public function destroy($id)
{
    // Busca la marca por ID
    $marca = Marca::findOrFail($id);

    // Registra la actividad
    activity()
        ->performedOn($marca)
        ->causedBy(auth()->user())
        ->log('Eliminó la marca: ' . $marca->nombre);

    // Elimina la marca
    $marca->delete();

    // Devuelve una respuesta JSON adecuada
    return response()->json(['message' => 'Marca eliminada correctamente.'], 200);
}


}

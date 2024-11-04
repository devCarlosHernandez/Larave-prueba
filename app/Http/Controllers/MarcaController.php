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
        return redirect()->route('marcas.index')->with('mensaje', 'Marca registrada'); // Redirect
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Buscar la marca por ID
        $marca = Marca::findOrFail($id);

        // Actualizar solo los campos que han sido enviados en la solicitud
        $marca->update($request->only('nombre')); // Esto se puede simplificar

        // Registrar la actividad
        activity()
            ->performedOn($marca)
            ->causedBy(auth()->user())
            ->log('Actualizó la marca: ' . $marca->nombre);

        // Devuelve una respuesta JSON si la solicitud espera JSON
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Marca actualizada correctamente.'], 200);
        }

        // Redirigir a la vista del índice con un mensaje si no es JSON
        return redirect()->route('marcas.index')->with('mensaje', 'Marca actualizada correctamente');
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
        try {
            // Busca la marca por ID
            $marca = Marca::findOrFail($id);

            // Registra la actividad
            activity()
                ->performedOn($marca)
                ->causedBy(auth()->user())
                ->log('Eliminó la marca: ' . $marca->nombre);

            // Elimina la marca
            $marca->delete();

            // Verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Marca eliminada correctamente.'], 200);
            }

            // Si no espera JSON, redirecciona a la vista con un mensaje de éxito
            return redirect()->route('marcas.index')->with('success', 'Marca eliminada correctamente.');

        } catch (\Exception $e) {
            // Si ocurre un error, verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Marca no encontrada.'], 404);
            }

            // Si no espera JSON, redirecciona a la vista con mensaje de error
            return redirect()->route('marcas.index')->with('error', 'Marca no encontrada.');
        }
    }



}

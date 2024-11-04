<?php

namespace App\Http\Controllers;

use App\Models\Categoria; // Asegúrate de que esto sea correcto
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoriaController extends Controller
{
    public function index()
    {

        if (request()->expectsJson()) {
            return response()->json(Categoria::all());
        }

        // Obtener todos los artículos
        $categorias = Categoria::with('productos')->get();
        $categorias = Categoria::paginate(50);
        return view('categorias.index', compact('categorias'));
    }

    public function create() {
        return view('categorias.form');
    }


    public function store(Request $request)
    {
        // Validar los campos necesarios
        $request->validate([
            'nombre' => 'required|max:45',
            'descripcion' => 'required|max:45',
        ]);

        // Crear la nueva categoría
        $categoria = Categoria::create($request->only('nombre', 'descripcion'));

        // Registrar la actividad
        activity()
            ->performedOn($categoria)
            ->causedBy(auth()->user())
            ->log('Creó una nueva categoría: ' . $categoria->nombre);

        // Si la solicitud espera JSON, retorna respuesta JSON
        if ($request->expectsJson()) {
            return response()->json(['mensaje' => 'Categoría registrada', 'categoria' => $categoria], 201);
        }

        // Redireccionar y agregar mensaje a la sesión
        Session::flash('mensaje', 'Categoría registrada');
        return redirect()->route('categorias.index')->with('mensaje', 'Categoría registrada');
    }

    public function update(Request $request, $id)
    {
        // Validar los campos necesarios
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);

        // Buscar la categoría por ID
        $categoria = Categoria::findOrFail($id);

        // Actualizar los campos
        $categoria->update($request->only('nombre', 'descripcion'));

        // Registrar la actividad
        activity()
            ->performedOn($categoria) // El modelo que estás registrando
            ->causedBy(auth()->user()) // Usuario que realiza la acción
            ->log('Actualizó la categoría: ' . $categoria->nombre);

        // Si la solicitud espera JSON, retorna respuesta JSON
        if ($request->expectsJson()) {
            return response()->json(['mensaje' => 'Categoría actualizada correctamente.', 'categoria' => $categoria], 200);
        }

        // Redireccionar y agregar mensaje a la sesión
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }



    public function show(Categoria $categoria)
    {
        return response()->json($categoria); // Solo devuelve el JSON
    }

    public function edit($id)
    {
        $categorias = Categoria::findOrFail($id);
        return view('categorias.form', compact('categorias'));
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);

            activity()
                ->performedOn($categoria)
                ->causedBy(auth()->user())
                ->log('Eliminó la categoría: ' . $categoria->nombre);

            $categoria->delete();

            // Verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Categoría eliminada correctamente.'], 200);
            }

            // Si no espera JSON, redirecciona a la vista
            return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');

        } catch (\Exception $e) {
            // Si ocurre un error, verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Categoría no encontrada.'], 404);
            }

            // Si no espera JSON, redirecciona a la vista con mensaje de error
            return redirect()->route('categorias.index')->with('error', 'Categoría no encontrada.');
        }
    }


}

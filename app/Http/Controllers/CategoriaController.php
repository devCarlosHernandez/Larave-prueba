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

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);


        $categorias = Categoria::findOrFail($id);

        $categorias->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        activity()
        ->performedOn($categorias) // El modelo que estás registrando
        ->causedBy(auth()->user()) // Usuario que realiza la acción
        ->log('Actualizó la categoría: ' . $categorias->nombre);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function show(Categoria $categorias)
    {
        return view('categorias.show', compact('categorias'));
    }

    public function edit($id)
    {
        $categorias = Categoria::findOrFail($id);
        return view('categorias.form', compact('categorias'));
    }

    public function destroy($id)
    {
    $categorias = Categoria::findOrFail($id);
    activity()
        ->performedOn($categorias) // El modelo que estás registrando
        ->causedBy(auth()->user()) // Usuario que realiza la acción
        ->log('Eliminó la categoría: ' . $categorias->nombre);
    $categorias->delete();

    return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }

}

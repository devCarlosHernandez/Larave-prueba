<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProveedoresController extends Controller
{


    public function index()
    {
        if (request()->expectsJson()) {
            return response()->json(Proveedores::all());
        }

        $proveedores = Proveedores::with('productos')->get();
        $proveedores = Proveedores::paginate(50);
        return view('proveedores.index', compact('proveedores'));
    }


    public function create() {
        return view('proveedores.form');
    }


    public function store(Request $request)
    {
        // Validar los campos necesarios
        $request->validate([
            'nombre' => 'required|max:45',
            'direccion' => 'required|max:45',
            'telefono' => 'required|max:45',
        ]);

        // Crear el nuevo proveedor
        $proveedores = Proveedores::create($request->only('nombre', 'direccion', 'telefono'));

        // Registrar la actividad
        activity()
            ->performedOn($proveedores)
            ->causedBy(auth()->user())
            ->log('Creó un nuevo proveedor: ' . $proveedores->nombre);

        // Si la solicitud espera JSON, retorna respuesta JSON
        if ($request->expectsJson()) {
            return response()->json(['mensaje' => 'Proveedor registrado', 'proveedor' => $proveedores], 201);
        }

        // Redireccionar y agregar mensaje a la sesión
        Session::flash('mensaje', 'Proveedor registrado');
        return redirect()->route('proveedores.index')->with('mensaje', 'Proveedor registrado');
    }


    public function update(Request $request, $id)
    {
        // Valida los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        // Busca la categoría por su ID
        $proveedores = Proveedores::findOrFail($id);

        // Actualiza los campos de la categoría
        $proveedores->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        activity()
        ->performedOn($proveedores)
        ->causedBy(auth()->user())
        ->log('Actualizó al proveedores: ' . $proveedores->nombre);

        // Redirige a la lista de categorías con un mensaje de éxito
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizada correctamente.');
    }

    public function show(Proveedores $proveedores) // Cambia a PascalCase
    {
        return view('proveedores.show', compact('proveedores'));
    }

    public function edit($id)
    {
        $proveedores = Proveedores::findOrFail($id); // Encuentra la categoría por ID
        return view('proveedores.form', compact('proveedores')); // Cambia a 'categories.form'
    }

    public function destroy($id)
    {
        try {
            // Encuentra el proveedor o lanza una excepción si no se encuentra
            $proveedores = Proveedores::findOrFail($id);

            // Registra la actividad
            activity()
                ->performedOn($proveedores)
                ->causedBy(auth()->user())
                ->log('Eliminó el proveedor: ' . $proveedores->nombre);

            // Elimina el proveedor
            $proveedores->delete();

            // Respuesta en caso de éxito
            return response()->json(['message' => 'Proveedor eliminado correctamente.'], 200);
        } catch (\Exception $e) {
            // Manejo de errores en caso de fallo
            return response()->json(['error' => 'Hubo un problema al eliminar el proveedor.'], 500);
        }
    }


    public function assignProducts(Request $request, $id)
    {
        $proveedores = Proveedores::findOrFail($id);
        $proveedores->productos()->sync($request->productos);

        return redirect()->route('proveedores.index')->with('success', 'Productos asignados correctamente.');
    }
}

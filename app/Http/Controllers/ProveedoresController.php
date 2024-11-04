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

        // Busca el proveedor por su ID
        $proveedor = Proveedores::findOrFail($id);

        // Actualiza los campos del proveedor
        $proveedor->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        // Registrar la actividad
        activity()
            ->performedOn($proveedor) // El modelo que estás registrando
            ->causedBy(auth()->user()) // Usuario que realiza la acción
            ->log('Actualizó al proveedor: ' . $proveedor->nombre);

        // Si la solicitud espera JSON, retorna respuesta JSON
        if ($request->expectsJson()) {
            return response()->json(['mensaje' => 'Proveedor actualizado correctamente.', 'proveedor' => $proveedor], 200);
        }

        // Redirecciona y agrega mensaje a la sesión
        Session::flash('mensaje', 'Proveedor actualizado correctamente.');
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }


    public function show(Proveedores $proveedores)
    {
        return response()->json($proveedores);
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
            $proveedor = Proveedores::findOrFail($id);

            // Registra la actividad
            activity()
                ->performedOn($proveedor)
                ->causedBy(auth()->user())
                ->log('Eliminó el proveedor: ' . $proveedor->nombre);

            // Elimina el proveedor
            $proveedor->delete();

            // Verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Proveedor eliminado correctamente.'], 200);
            }

            // Si no espera JSON, redirecciona a la vista
            Session::flash('mensaje', 'Proveedor eliminado correctamente.');
            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');

        } catch (\Exception $e) {
            // Si ocurre un error, verifica si la solicitud espera JSON
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Proveedor no encontrado o hubo un problema al eliminar.'], 404);
            }

            // Si no espera JSON, redirecciona a la vista con mensaje de error
            Session::flash('mensaje', 'Proveedor eliminado correctamente.');
            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
        }
    }


    public function assignProducts(Request $request, $id)
    {
        $proveedores = Proveedores::findOrFail($id);
        $proveedores->productos()->sync($request->productos);

        return redirect()->route('proveedores.index')->with('success', 'Productos asignados correctamente.');
    }
}

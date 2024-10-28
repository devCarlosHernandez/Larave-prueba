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
        $proveedores = Proveedores::all();
        return view('proveedores.index', compact('proveedores'));
    }


    public function create() {
        return view('proveedores.form');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:45',
            'direccion' => 'required|max:45',
            'telefono' => 'required|max:45',
        ]);


        $proveedores = Proveedores::create($request->only(
            'nombre',
            'direccion',
            'telefono',
        ));

        activity()
            ->performedOn($proveedores) 
            ->causedBy(auth()->user()) 
            ->log('Creó un nuevo proveedor: ' . $proveedores->nombre);

        Session::flash('mensaje', 'Proveedor registrada');

        return redirect()->route('proveedores.index')->with('mensaje', 'Proveedor registrada');
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
    $proveedores = Proveedores::findOrFail($id);
    activity()
        ->performedOn($proveedores) 
        ->causedBy(auth()->user()) 
        ->log('Eliminó la marca: ' . $proveedores->nombre);
    $proveedores->delete();

    return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminada correctamente.');
    }

    public function assignProducts(Request $request, $id)
    {
        $proveedores = Proveedores::findOrFail($id);
        $proveedores->productos()->sync($request->productos);

        return redirect()->route('proveedores.index')->with('success', 'Productos asignados correctamente.');
    }
}

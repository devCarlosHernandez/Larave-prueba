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
    $marca = Marca::with('productos')->get();
    return view('marcas.index', compact('marca'));
}

    public function create()
    {
        $productos = Producto::all(); 
        return view('marcas.form', compact('productos'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:45',
            'producto_id' => 'required|max:45',
        ]);


        $marca = Marca::create($request->only(
            'nombre',
            'producto_id',
        ));

        activity()
            ->performedOn($marca) 
            ->causedBy(auth()->user()) 
            ->log('Creó una nueva marca: ' . $marca->nombre);

        Session::flash('mensaje', 'Categoria registrada');

        return redirect()->route('marcas.index')->with('mensaje', 'Categoria registrada');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'producto_id' => 'required|string|max:255',
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
 
        return redirect()->route('marcas.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function show(Marca $marca) 
    {
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
    $marca = Marca::findOrFail($id);

    activity()
        ->performedOn($marca) 
        ->causedBy(auth()->user()) 
        ->log('Eliminó la marca: ' . $marca->nombre);
    $marca->delete();

    return redirect()->route('marcas.index')->with('success', 'Categoría eliminada correctamente.');
    }

}
<?php

namespace App\Http\Controllers;


use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategorias = Subcategoria::with('categoria')->get();
        $categorias = Categoria::all();

        return view('modules.recetario.ingredients.subcategorias.index', compact('subcategorias', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
         $request->validate([
        'nombre' => 'required',
        'categoria_id' => 'required'
            ]);

            Subcategoria::create($request->all());

            return back()->with('success', 'Subcategoría creada');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        Subcategoria::create([
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id
        ]);

        return back()->with('success', 'Subcategoría creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sub = Subcategoria::findOrFail($id);
        $sub->delete();

        return back()->with('success', 'Subcategoría eliminada');
    }
}

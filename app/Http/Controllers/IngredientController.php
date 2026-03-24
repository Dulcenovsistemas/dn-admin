<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{

    public function index()
    {
        $ingredients = Ingredient::all();

        return view('modules.recetario.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        if(!auth()->user()->hasModulePermission('recetario','create')){
            abort(403);
        }

        return view('modules.recetario.ingredients.create');
    }

    public function store(Request $request)
    {
        if(!auth()->user()->hasModulePermission('recetario','create')){
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'cost_per_unit' => 'required|numeric'
        ]);

        Ingredient::create($request->all());

        return redirect()->route('ingredientes.index')
                        ->with('success','Ingrediente creado');
    }

   public function edit($id)
    {
        if(!auth()->user()->hasModulePermission('recetario','edit')){
            abort(403);
        }

        $ingredient = Ingredient::findOrFail($id);

        return view('modules.recetario.ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, $id)
    {
        if(!auth()->user()->hasModulePermission('recetario','edit')){
            abort(403);
        }

        $ingredient = Ingredient::findOrFail($id);

        $ingredient->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'cost_per_unit' => $request->cost_per_unit
        ]);

        return redirect()->route('ingredientes.index')
                        ->with('success', 'Ingrediente actualizado');
    }

    public function destroy($id)
    {
        if(!auth()->user()->hasModulePermission('recetario','delete')){
            abort(403);
        }

        $ingredient = Ingredient::findOrFail($id);

        $ingredient->delete();

        return redirect()->route('ingredientes.index')
                        ->with('success', 'Ingrediente eliminado');
    }

}
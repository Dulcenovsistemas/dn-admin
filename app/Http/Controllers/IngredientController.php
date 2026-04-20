<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Categoria;
use App\Models\Subcategoria;

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

        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();


        
        return view('modules.recetario.ingredients.create', compact('categorias', 'subcategorias'));
    }

    public function store(Request $request)
    {
        if(!auth()->user()->hasModulePermission('recetario','create')){
            abort(403);
        }

        // 🧠 Validación base
        $request->validate([
            'name' => 'required',
            'unit' => 'required|in:KG,PZ,LT',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'cost_per_unit' => 'required|numeric',
        ]);

        // 🧃 Validación extra si es batido
        $categoria = \App\Models\Categoria::find($request->categoria_id);

        if ($categoria && str_contains(strtolower($categoria->nombre), 'batido')) {
            $request->validate([
                'cost_per_bucket' => 'required|numeric',
                'cost_per_liter' => 'required|numeric',
            ]);
        }

        // 💾 Guardar
        Ingredient::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'cost_per_unit' => $request->cost_per_unit,
            'categoria_id' => $request->categoria_id,
            'subcategoria_id' => $request->subcategoria_id,
            'cost_per_bucket' => $request->cost_per_bucket,
            'cost_per_liter' => $request->cost_per_liter,
        ]);

        return redirect()->route('ingredientes.index')
                        ->with('success','Ingrediente creado');
    }

    public function edit($id)
    {
        if(!auth()->user()->hasModulePermission('recetario','edit')){
            abort(403);
        }

        $ingredient = Ingredient::findOrFail($id);
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();

        // 🔥 Obtener ID de categoría batidos
        $batidoCategoriaId = Categoria::where('nombre', 'like', '%batido%')->value('id');

        return view('modules.recetario.ingredients.edit', compact(
            'ingredient',
            'categorias',
            'subcategorias',
            'batidoCategoriaId'
        ));
    }

    
    public function update(Request $request, $id)
    {
        if(!auth()->user()->hasModulePermission('recetario','edit')){
            abort(403);
        }

        $ingredient = Ingredient::findOrFail($id);

        // 🧠 Validación base
        $request->validate([
            'name' => 'required',
            'unit' => 'required|in:KG,PZ,LT',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'cost_per_unit' => 'required|numeric',
        ]);

        // 🧃 Validación si es batido
        $categoria = \App\Models\Categoria::find($request->categoria_id);

        if ($categoria && str_contains(strtolower($categoria->nombre), 'batido')) {
            $request->validate([
                'cost_per_bucket' => 'required|numeric',
                'cost_per_liter' => 'required|numeric',
            ]);
        }

        // 💾 Update completo
        $ingredient->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'cost_per_unit' => $request->cost_per_unit,
            'categoria_id' => $request->categoria_id,
            'subcategoria_id' => $request->subcategoria_id,
            'cost_per_bucket' => $request->cost_per_bucket,
            'cost_per_liter' => $request->cost_per_liter,
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
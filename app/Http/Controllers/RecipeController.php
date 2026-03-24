<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\RecipeItem;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        if(!auth()->user()->hasModulePermission('recetario','view')){
            abort(403);
        }

        $recipes = Recipe::all();

        return view(
            'modules.recetario.recipes.index',
            compact('recipes')
        );
    }

    public function create()
    {
        if(!auth()->user()->hasModulePermission('recetario','create')){
            abort(403);
        }

        $ingredients = Ingredient::all();
        $recipes = Recipe::where('type','preparation')->get();

        return view(
            'modules.recetario.recipes.create',
            compact('ingredients','recipes')
        );
    }

    public function store(Request $request)
    {
        if(!auth()->user()->hasModulePermission('recetario','create')){
            abort(403);
        }

        $recipe = Recipe::create([
            'name' => $request->name,
            'type' => $request->type,
            'labor_cost' => $request->labor_cost,
            'yield' => $request->yield
        ]);

        if($request->items){

            foreach($request->items as $item){

                RecipeItem::create([
                    'recipe_id' => $recipe->id,
                    'item_type' => $item['type'],
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit']
                ]);

            }

        }

        return redirect()->route('recetas.index');
    }

    public function show($id)
    {
        if(!auth()->user()->hasModulePermission('recetario','view')){
            abort(403);
        }

        $recipe = Recipe::findOrFail($id);

        return view(
            'modules.recetario.recipes.show',
            compact('recipe')
        );
    }

    public function edit($id)
    {
        if(!auth()->user()->hasModulePermission('recetario','edit')){
            abort(403);
        }

        $recipe = Recipe::findOrFail($id);

        $ingredients = Ingredient::all();

        $recipes = Recipe::where('type','preparation')
                    ->where('id','!=',$id)
                    ->get();

        return view(
            'modules.recetario.recipes.edit',
            compact('recipe','ingredients','recipes')
        );
    }

    public function update(Request $request, $id)
    {
        if(!auth()->user()->hasModulePermission('recetario','edit')){
            abort(403);
        }

        $recipe = Recipe::findOrFail($id);

        $recipe->update([
            'name' => $request->name,
            'type' => $request->type,
            'labor_cost' => $request->labor_cost,
            'yield' => $request->yield
        ]);

        // eliminar items anteriores
        RecipeItem::where('recipe_id',$id)->delete();

        if($request->items){

            foreach($request->items as $item){

                RecipeItem::create([
                    'recipe_id' => $recipe->id,
                    'item_type' => $item['type'],
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit']
                ]);

            }

        }

        return redirect()->route('recetas.index')
                        ->with('success','Receta actualizada');
    }

    public function destroy($id)
    {
        if(!auth()->user()->hasModulePermission('recetario','delete')){
            abort(403);
        }

        $recipe = Recipe::findOrFail($id);

        RecipeItem::where('recipe_id',$id)->delete();

        $recipe->delete();

        return redirect()->route('recetas.index')
                        ->with('success','Receta eliminada');
    }


}

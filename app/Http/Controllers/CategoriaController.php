<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('modules.recetario.ingredients.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return back()->with('success', 'Categoría creada');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // eliminar hijos también
        $category->children()->delete();

        $category->delete();

        return back()->with('success', 'Categoría eliminada');
    }
}
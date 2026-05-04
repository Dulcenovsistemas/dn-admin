<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('modules.recetario.categorias.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('modules.recetario.categorias.create', compact('categories'));
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

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria creada');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // eliminar hijos también
        $category->children()->delete();

        $category->delete();

        return back()->with('success', 'Categoría eliminada');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        // Solo categorías padre para evitar loops raros
        $categories = Category::whereNull('parent_id')->where('id', '!=', $id)->get();

        return view('modules.recetario.categorias.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?: null
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Actualizado correctamente');
    }

}
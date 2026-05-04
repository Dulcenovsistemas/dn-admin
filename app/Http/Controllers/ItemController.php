<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemCost;
use App\Models\Category;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['category','subcategory','costs'])->get();

        return view('modules.recetario.items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        $subcategories = Category::whereNotNull('parent_id')->get();

        return view('modules.recetario.items.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'unit' => 'required'
        ]);

        $item = Item::create([
            'name' => $request->name,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'unit' => $request->unit,
        ]);

        return redirect()->route('items.costs', $item->id);
    }


    public function costs($id)
    {
        $item = Item::findOrFail($id);

        return view('modules.recetario.items.costs', compact('item'));
    }

    public function storeCosts(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        if (!$request->has('costs')) {
            return back()->with('error', 'No se enviaron costos');
        }

        foreach ($request->costs as $cost) {

            if (!empty($cost['cost'])) {

                ItemCost::updateOrCreate(
                    [
                        'item_id' => $item->id,
                        'cost_type' => $cost['type']
                    ],
                    [
                        'cost' => $cost['cost']
                    ]
                );

            }

        }

        return redirect()->route('items.index')
            ->with('success', 'Costos guardados correctamente');
    }
}
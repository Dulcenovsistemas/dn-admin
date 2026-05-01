<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['category','parent'])->get();

        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        $items = Item::all(); // para variantes

        return view('modules.recetario.items.create', compact('categories','items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'parent_id' => 'nullable|exists:items,id',
            'unit' => 'required'
        ]);

        Item::create($request->all());

        return redirect()->route('items.costs', $item->id);
    }

    public function costs($id)
    {
        $item = Item::findOrFail($id);

        return view('items.costs', compact('item'));
    }

    public function storeCosts(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        foreach ($request->costs as $cost) {
            ItemCost::create([
                'item_id' => $item->id,
                'cost_type' => $cost['type'],
                'cost' => $cost['cost']
            ]);
        }

        return redirect()->route('items.index')
            ->with('success','Costos guardados');
    }
}

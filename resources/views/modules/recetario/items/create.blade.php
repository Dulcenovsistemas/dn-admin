@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Recetario
</h1>

  <h1 class="text-xl font-bold mb-4">Nuevo Item</h1>

<form method="POST" action="{{ route('items.store') }}">
@csrf

<div class="grid grid-cols-2 gap-4">

    <input name="name" placeholder="Nombre"
        class="border p-2 rounded">

    <select name="type" class="border p-2 rounded">
        <option value="ingredient">Ingrediente</option>
        <option value="raw_material">Materia prima</option>
        <option value="product">Producto</option>
    </select>

    <select name="category_id" class="border p-2 rounded">
        <option value="">Categoría</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">
                {{ $cat->name }}
            </option>
        @endforeach
    </select>

    <select name="parent_id" class="border p-2 rounded">
        <option value="">Sin variante</option>
        @foreach($items as $item)
            <option value="{{ $item->id }}">
                {{ $item->name }}
            </option>
        @endforeach
    </select>

    <select name="unit" class="border p-2 rounded">
        <option value="KG">KG</option>
        <option value="LT">LT</option>
        <option value="PZ">PZ</option>
    </select>

</div>

<button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
Guardar
</button>

</form>

@endsection
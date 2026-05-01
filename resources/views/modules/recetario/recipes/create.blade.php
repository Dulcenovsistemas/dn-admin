@extends('layouts.erp')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <h1 class="text-2xl font-semibold mb-1">Nueva Receta</h1>
    <p class="text-gray-500 mb-6">Define los componentes y costos de la receta</p>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-md p-6">

        <form action="{{ route('recetas.store') }}" method="POST">
        @csrf

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm text-gray-600">Nombre</label>
                <input type="text" name="name"
                    class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="text-sm text-gray-600">Tipo</label>
                <select name="type"
                    class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="producto">Producto</option>
                    <option value="preparacion">Preparación</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Costo mano de obra</label>
                <input type="number" step="0.01" name="labor_cost"
                    class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none" value="162">
            </div>

            <div>
                <label class="text-sm text-gray-600">Rendimiento</label>
                <input type="number" step="0.01" name="yield"
                    class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

        </div>

        {{-- COMPONENTES --}}
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-3">Componentes</h2>

            <div class="overflow-hidden border rounded-xl">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="p-3 text-left">Tipo</th>
                            <th class="p-3 text-left">Item</th>
                            <th class="p-3 text-left">Cantidad</th>
                            <th class="p-3 text-left">Unidad</th>
                            <th class="p-3 text-right"></th>
                        </tr>
                    </thead>

                    <tbody id="itemsBody"></tbody>

                </table>

            </div>

            {{-- BOTÓN AGREGAR --}}
            <button
            type="button"
            onclick="addItem()"
            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Agregar componente
            </button>
        </div>

        {{-- BOTONES --}}
        <div class="flex justify-end gap-3 mt-8">

            <a href="{{ route('recetas.index') }}"
               class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                Cancelar
            </a>

            <button
                class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition shadow-sm">
                Guardar receta
            </button>

        </div>

        </form>

    </div>

</div>

@endsection

<script>

let itemIndex = 0;

function addItem(){

let row = `
<tr class="border-t hover:bg-gray-50 transition">

<td class="p-2">
<select name="items[${itemIndex}][type]" 
    class="border rounded-md p-1 w-full text-sm">
<option value="ingredient">Ingrediente</option>
<option value="recipe">Preparación</option>
</select>
</td>

<td class="p-2">
<select 
name="items[${itemIndex}][id]" 
class="border rounded-md p-1 w-full text-sm"
onchange="setUnit(this, ${itemIndex})">

<option value="">Seleccionar</option>

@foreach($ingredients as $ingredient)
<option value="{{ $ingredient->id }}" data-unit="{{ $ingredient->unit }}">
{{ $ingredient->name }}
</option>
@endforeach

@foreach($recipes as $recipe)
<option value="{{ $recipe->id }}" data-unit="PZ">
{{ $recipe->name }}
</option>
@endforeach

</select>
</td>

<td class="p-2">
<input type="number" step="0.0001"
name="items[${itemIndex}][quantity]"
class="border rounded-md p-1 w-full text-sm">
</td>

<td class="p-2">
<input type="text"
name="items[${itemIndex}][unit]"
id="unit-${itemIndex}"
class="border rounded-md p-1 w-full bg-gray-100 text-sm"
readonly>
</td>

<td class="p-2 text-right">
<button type="button"
class="w-7 h-7 flex items-center justify-center 
rounded-full bg-red-50 text-red-500 
hover:bg-red-100 hover:text-red-600 transition"
onclick="this.closest('tr').remove()">
✕
</button>
</td>

</tr>
`;

document
.querySelector("#itemsBody")
.insertAdjacentHTML("beforeend", row);

itemIndex++;
}


// 🔥 AUTOCOMPLETAR UNIDAD
function setUnit(select, index) {
    const option = select.options[select.selectedIndex];
    const unit = option.getAttribute('data-unit');

    document.getElementById(`unit-${index}`).value = unit || '';
}

</script>
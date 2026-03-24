@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-bold mb-4">
Editar Receta
</h1>

    <form action="{{ route('recetas.update', $recipe->id) }}" method="POST">

    @csrf
    @method('PUT')

        <div class="mb-4">
            <label>Nombre</label>
            <input type="text"
            name="name"
            value="{{ $recipe->name }}"
            class="border p-2 w-full">
        </div>


        <div class="mb-4">
            <label>Tipo</label>

                <select name="type" class="border p-2 w-full">

                    <option value="producto"
                    {{ $recipe->type == 'producto' ? 'selected' : '' }}>
                    Producto
                    </option>

                    <option value="preparacion"
                    {{ $recipe->type == 'preparacion' ? 'selected' : '' }}>
                    Preparación
                    </option>

            </select>

        </div>


        <div class="mb-4">
            <label>Costo mano de obra</label>

                <input type="number"
                step="0.01"
                name="labor_cost"
                value="{{ $recipe->labor_cost }}"
                class="border p-2 w-full">

        </div>


        <div class="mb-4">
            <label>Rendimiento</label>

            <input type="number"
            step="0.01"
            name="yield"
            value="{{ $recipe->yield }}"
            class="border p-2 w-full">

        </div>


        <h2 class="text-xl font-semibold mt-6 mb-2">
        Componentes
        </h2>


        <table class="w-full border" id="itemsTable">

            <thead>

                <tr class="bg-gray-200">

                    <th class="p-2">Tipo</th>
                    <th class="p-2">Item</th>
                    <th class="p-2">Cantidad</th>
                    <th class="p-2">Unidad</th>
                    <th class="p-2"></th>

                </tr>

            </thead>


            <tbody>

                @foreach($recipe->items as $index => $item)

                <tr>

                    <td>

                        <select name="items[{{ $index }}][type]" class="border p-1 w-full">

                            <option value="ingredient"
                            {{ $item->item_type == 'ingredient' ? 'selected' : '' }}>
                            Ingrediente
                            </option>

                            <option value="recipe"
                            {{ $item->item_type == 'recipe' ? 'selected' : '' }}>
                            Preparación
                            </option>

                        </select>

                    </td>


                    <td>

                        <select name="items[{{ $index }}][id]" class="border p-1 w-full">

                            <option value="">Seleccionar</option>

                            @foreach($ingredients as $ingredient)

                            <option value="{{ $ingredient->id }}"
                            {{ $item->item_type == 'ingredient' && $item->item_id == $ingredient->id ? 'selected' : '' }}>

                            Ingrediente: {{ $ingredient->name }}

                            </option>

                            @endforeach


                            @foreach($recipes as $recipeOption)

                            <option value="{{ $recipeOption->id }}"
                            {{ $item->item_type == 'recipe' && $item->item_id == $recipeOption->id ? 'selected' : '' }}>

                            Preparación: {{ $recipeOption->name }}

                            </option>

                            @endforeach

                        </select>

                    </td>


                    <td>

                        <input
                        type="number"
                        step="0.0001"
                        name="items[{{ $index }}][quantity]"
                        value="{{ $item->quantity }}"
                        class="border p-1 w-full">

                    </td>


                    <td>

                        <input
                        type="text"
                        name="items[{{ $index }}][unit]"
                        value="{{ $item->unit }}"
                        class="border p-1 w-full">

                    </td>


                    <td>

                        <button
                        type="button"
                        class="bg-red-500 text-white px-2 py-1 rounded"
                        onclick="this.closest('tr').remove()">

                        X

                        </button>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>


        <button
            type="button"
            onclick="addItem()"
            class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">

            Agregar componente

        </button>


        <button class="bg-green-600 text-white px-4 py-2 mt-6 rounded">
            Actualizar receta
        </button>

    </form>

@endsection


<script>

    let itemIndex = {{ $recipe->items->count() }};

    function addItem(){

    let row = `

    <tr>

    <td>

    <select name="items[${itemIndex}][type]" class="border p-1 w-full">

    <option value="ingredient">Ingrediente</option>
    <option value="recipe">Preparación</option>

    </select>

    </td>


    <td>

    <select name="items[${itemIndex}][id]" class="border p-1 w-full">

    <option value="">Seleccionar</option>

    @foreach($ingredients as $ingredient)

    <option value="{{ $ingredient->id }}">
    Ingrediente: {{ $ingredient->name }}
    </option>

    @endforeach


    @foreach($recipes as $recipe)

    <option value="{{ $recipe->id }}">
    Preparación: {{ $recipe->name }}
    </option>

    @endforeach

    </select>

    </td>


    <td>

    <input
    type="number"
    step="0.0001"
    name="items[${itemIndex}][quantity]"
    class="border p-1 w-full">

    </td>


    <td>

    <input
    type="text"
    name="items[${itemIndex}][unit]"
    class="border p-1 w-full">

    </td>


    <td>

    <button
    type="button"
    class="bg-red-500 text-white px-2 py-1 rounded"
    onclick="this.closest('tr').remove()">

    X

    </button>

    </td>

    </tr>

    `;

    document
    .querySelector("#itemsTable tbody")
    .insertAdjacentHTML("beforeend", row);

    itemIndex++;

    }

</script>
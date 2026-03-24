@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-bold mb-4">
{{ $recipe->name }}
</h1>

    <div class="mb-4">

        <p><strong>Tipo:</strong> {{ $recipe->type }}</p>

        <p><strong>Rendimiento:</strong> {{ $recipe->yield }}</p>

        <p><strong>Mano de obra:</strong> {{ $recipe->labor_cost }}</p>

        <p><strong>Costo total:</strong> {{ number_format($recipe->calculateCost(),2) }}</p>

        <p><strong>Costo por unidad:</strong> {{ number_format($recipe->unitCost(),2) }}</p>

    </div>

    <h2 class="text-xl font-semibold mb-3">
    Componentes
    </h2>

    <table class="w-full border">

        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Tipo</th>
                <th class="p-2">Nombre</th>
                <th class="p-2">Cantidad</th>
                <th class="p-2">Unidad</th>
            </tr>
        </thead>

        <tbody>

        @foreach($recipe->items as $item)

            <tr class="border-t">

                <td class="p-2">

                    @if($item->item_type == 'ingredient')
                    Ingrediente
                    @else
                    Preparación
                    @endif

                </td>

                <td class="p-2">

                    @if($item->item_type == 'ingredient')

                        {{ \App\Models\Ingredient::find($item->item_id)->name ?? '' }}

                        @else

                            <a href="{{ route('recetas.show',$item->item_id) }}"
                            class="text-blue-600">

                            {{ \App\Models\Recipe::find($item->item_id)->name ?? '' }}

                            </a>

                    @endif

                </td>

                <td class="p-2">
                {{ $item->quantity }}
                </td>

                <td class="p-2">
                {{ $item->unit }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

@endsection
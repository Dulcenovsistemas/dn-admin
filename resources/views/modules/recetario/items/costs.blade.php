@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Costos de: {{ $item->name }}
</h1>

<div class="bg-white p-6 rounded-xl shadow max-w-xl">

<form method="POST" action="{{ route('items.costs.store', $item->id) }}">
@csrf

    <!-- 🔥 Tipo de costo automático -->
    <div id="cost-container"></div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
        Guardar costos
    </button>

</form>

</div>

@php
    $costs = $item->costs->keyBy('cost_type');
@endphp
<script>
    const categoryName = @json($item->category->name);
    const costs = @json($costs);

    const container = document.getElementById('cost-container');

    if (categoryName.toLowerCase().includes('batido')) {

        container.innerHTML = `
            <div class="mb-4">
                <label class="block text-sm mb-1">Costo por cubeta</label>
                <input name="costs[0][type]" type="hidden" value="cubeta">
                <input name="costs[0][cost]" type="number" step="0.01"
                    value="${costs.cubeta?.cost ?? ''}"
                    class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1">Costo por litro</label>
                <input name="costs[1][type]" type="hidden" value="litro">
                <input name="costs[1][cost]" type="number" step="0.01"
                    value="${costs.litro?.cost ?? ''}"
                    class="w-full border p-2 rounded">
            </div>
        `;

    } else {

        container.innerHTML = `
            <div class="mb-4">
                <label class="block text-sm mb-1">Costo</label>
                <input name="costs[0][type]" type="hidden" value="base">
                <input name="costs[0][cost]" type="number" step="0.01"
                    value="${costs.base?.cost ?? ''}"
                    class="w-full border p-2 rounded">
            </div>
        `;
    }
</script>
@endsection
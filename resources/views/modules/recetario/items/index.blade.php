@extends('layouts.erp')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Items</h1>

    <a href="{{ route('items.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded">
        + Nuevo
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">Nombre</th>
            <th class="p-3 text-left">Tipo</th>
            <th class="p-3 text-left">Unidad</th>
            <th class="p-3 text-left">Costo</th>
            <th class="p-3 text-right">Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse($items as $item)
            <tr class="border-b">
                <td class="p-3">{{ $item->name }}</td>
                <td class="p-3 capitalize">{{ $item->type }}</td>
                <td class="p-3">{{ $item->unit }}</td>
                <td class="p-3">
                    @if($item->costs->count())

                        @php
                            $cubeta = $item->costs->where('cost_type', 'cubeta')->first();
                            $litro = $item->costs->where('cost_type', 'litro')->first();
                            $base = $item->costs->where('cost_type', 'base')->first();
                        @endphp

                        <!-- 🔥 BATIDOS -->
                        @if($cubeta || $litro)
                            <div class="flex flex-col text-xs">
                                @if($cubeta)
                                    <span class="text-blue-600">
                                        Cubeta: ${{ number_format($cubeta->cost, 2) }}
                                    </span>
                                @endif

                                @if($litro)
                                    <span class="text-green-600">
                                        Litro: ${{ number_format($litro->cost, 2) }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <!-- 🔥 COSTO NORMAL -->
                            <span>
                                ${{ number_format($base?->cost ?? 0, 2) }}
                            </span>
                        @endif

                    @else
                        <span class="text-gray-400">Sin costo</span>
                    @endif
                </td>

                <td class="p-3 text-right flex gap-2 justify-end">

                    <a href="{{ route('items.costs', $item->id) }}" class="text-green-600">
                        Costos
                    </a>

                    <a href="{{ route('items.edit', $item->id) }}" class="text-blue-600">Editar</a>

                    <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-400">
                    No hay items
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>

@endsection
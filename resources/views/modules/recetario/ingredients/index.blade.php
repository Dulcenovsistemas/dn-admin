@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-bold mb-4">
Ingredientes
</h1>

@if(auth()->user()->hasModulePermission('recetario','create'))
    <a href="{{ route('ingredientes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
        Nuevo ingrediente
    </a>
@endif

<table class="mt-4 w-full border">

    <thead class="bg-gray-200">
        <tr>
            <th class="p-2">Nombre</th>
            <th class="p-2">Unidad</th>
            <th class="p-2">Costo</th>
            <th class="p-2">Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($ingredients as $ingredient)
        <tr class="border-b">
            <td class="p-2">{{ $ingredient->name }}</td>
            <td class="p-2">{{ $ingredient->unit }}</td>
            <td class="p-2">${{ $ingredient->cost_per_unit }}</td>
            <td class="flex gap-2">

                @if(auth()->user()->hasModulePermission('recetario','edit'))
                <a href="{{ route('ingredientes.edit',$ingredient->id) }}">
                Editar
                </a>
                @endif

                    @if(auth()->user()->hasModulePermission('recetario','delete'))
                    <form action="{{ route('ingredientes.destroy', $ingredient->id) }}" 
                        method="POST"
                        onsubmit="return confirm('¿Eliminar ingrediente?')">

                        @csrf
                        @method('DELETE')

                        <button class="bg-red-500 text-white px-2 py-1 rounded">
                            Eliminar
                        </button>

                    </form>
                    @endif

            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection
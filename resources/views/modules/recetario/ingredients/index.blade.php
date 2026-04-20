@extends('layouts.erp')

@section('content')

{{-- 🔹 HEADER --}}
<div class="flex items-center justify-between mb-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('categorias.index') }}" 
           class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
            ← Categorías
        </a>

        <h1 class="text-2xl font-bold">
            Ingredientes
        </h1>
    </div>

    @if(auth()->user()->hasModulePermission('recetario','create'))
        <a href="{{ route('ingredientes.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">
            + Nuevo ingrediente
        </a>
    @endif

</div>

{{-- 🔥 TABLA MODERNA --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-3 text-left">Nombre</th>
                <th class="p-3 text-left">Unidad</th>
                <th class="p-3 text-left">Categoria</th>
                <th  class="p-3 text-left">Subcateforia</th>
                <th class="p-3 text-left">Costo</th>
                <th class="p-3 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody>

            @foreach($ingredients as $ingredient)
            <tr class="border-t hover:bg-gray-50 transition">

                <td class="p-3 font-medium text-gray-800">
                    {{ $ingredient->name }}
                </td>

                <td class="p-3 text-gray-600">
                    {{ $ingredient->unit }}
                </td>

                <td class="p-3 text-gray-600">
                    {{ $ingredient->categoria->nombre ?? '-' }}
                </td>

                <td class="p-3 text-gray-600">
                    {{ $ingredient->subcategoria->nombre ?? '-' }}
                </td>


       

                <td class="p-3 text-gray-700 font-semibold">
                    ${{ number_format($ingredient->cost_per_unit, 2) }}
                </td>

                <td class="p-3">
                    <div class="flex justify-end gap-2">

                        {{-- ✏️ Editar --}}
                        @if(auth()->user()->hasModulePermission('recetario','edit'))
                        <a href="{{ route('ingredientes.edit',$ingredient->id) }}"
                           class="px-3 py-1 rounded-md text-xs bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                            Editar
                        </a>
                        @endif

                        {{-- 🗑️ Eliminar --}}
                        @if(auth()->user()->hasModulePermission('recetario','delete'))
                        <form action="{{ route('ingredientes.destroy', $ingredient->id) }}" 
                              method="POST"
                              onsubmit="return confirm('¿Eliminar ingrediente?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="px-3 py-1 rounded-md text-xs bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 transition">
                                Eliminar
                            </button>

                        </form>
                        @endif

                    </div>
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

</div>

@endsection
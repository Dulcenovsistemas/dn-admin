@extends('layouts.erp')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-semibold">Recetas</h1>
            <p class="text-gray-500 text-sm">Administra y analiza costos de recetas</p>
        </div>

        @if(auth()->user()->hasModulePermission('recetario','create'))
            <a href="{{ route('recetas.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-sm">
                + Nueva receta
            </a>
        @endif

    </div>

    {{-- TABLA --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Tipo</th>
                    <th class="p-3 text-left">Rendimiento</th>
                    <th class="p-3 text-left">Costo total</th>
                    <th class="p-3 text-left">Costo unitario</th>
                    <th class="p-3 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>

                @foreach($recipes as $recipe)

                <tr class="border-t hover:bg-gray-50 transition">

                    {{-- Nombre --}}
                    <td class="p-3 font-medium text-gray-800">
                        {{ $recipe->name }}
                    </td>

                    {{-- Tipo --}}
                    <td class="p-3">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $recipe->type == 'producto' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($recipe->type) }}
                        </span>
                    </td>

                    {{-- Rendimiento --}}
                    <td class="p-3 text-gray-600">
                        {{ $recipe->yield }}
                    </td>

                    {{-- Costo total --}}
                    <td class="p-3 font-semibold text-gray-800">
                        ${{ number_format($recipe->calculateCost(),2) }}
                    </td>

                    {{-- Costo unitario --}}
                    <td class="p-3 font-semibold text-blue-600">
                        ${{ number_format($recipe->unitCost(),2) }}
                    </td>

                    {{-- Acciones --}}
                    <td class="p-3">
                        <div class="flex justify-end gap-2">

                            {{-- Ver --}}
                            <a href="{{ route('recetas.show', $recipe->id) }}"
                               class="px-3 py-1 rounded-md text-xs bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                Ver
                            </a>

                            {{-- Editar --}}
                            @if(auth()->user()->hasModulePermission('recetario','edit'))
                            <a href="{{ route('recetas.edit', $recipe->id) }}"
                               class="px-3 py-1 rounded-md text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                Editar
                            </a>
                            @endif

                            {{-- Eliminar --}}
                            @if(auth()->user()->hasModulePermission('recetario','delete'))
                            <form action="{{ route('recetas.destroy', $recipe->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar receta?')">

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

</div>

@endsection
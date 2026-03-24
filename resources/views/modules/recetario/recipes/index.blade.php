@extends('layouts.erp')

@section('content')

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold">
        Recetas
        </h1>

        @if(auth()->user()->hasModulePermission('recetario','create'))
            <a href="{{ route('recetas.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded">

            Nueva receta

            </a>
        @endif

    </div>


    <table class="w-full border">

        <thead class="bg-gray-200">

            <tr>
                <th class="p-2">Nombre</th>
                <th class="p-2">Tipo</th>
                <th class="p-2">Rendimiento</th>
                <th class="p-2">Acciones</th>
            </tr>

        </thead>

        <tbody>

            @foreach($recipes as $recipe)

            <tr class="border-t">

                <td class="p-2">
                {{ $recipe->name }}
                </td>

                <td class="p-2">
                {{ $recipe->type }}
                </td>

                <td class="p-2">
                {{ $recipe->yield }}
                </td>

                <td>
                {{ number_format($recipe->calculateCost(),2) }}
                </td>

                <td>
                {{ number_format($recipe->unitCost(),2) }}
                </td>


                <td class="p-2 flex gap-2">
                    <a href="{{ route('recetas.show', $recipe->id) }}"
                    class="bg-gray-500 text-white px-2 py-1 rounded">

                    Ver

                    </a>

                    @if(auth()->user()->hasModulePermission('recetario','edit'))
                        <a href="{{ route('recetas.edit', $recipe->id) }}"
                        class="bg-blue-500 text-white px-2 py-1 rounded">
                        Editar
                        </a>
                    @endif

                    @if(auth()->user()->hasModulePermission('recetario','delete'))
                        <form action="{{ route('recetas.destroy', $recipe->id) }}" method="POST">

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
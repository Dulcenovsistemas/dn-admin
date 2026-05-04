@extends('layouts.erp')

@section('content')

<div class="flex justify-between items-center mb-6">
    
    <h1 class="text-2xl font-semibold">
        Categorías
    </h1>

    <a href="{{ route('categorias.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Nueva
    </a>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($categories as $category)
    <div class="bg-white rounded-xl shadow p-5 hover:shadow-md transition">

        <!-- Nombre categoría -->
        <h2 class="font-bold text-lg mb-3 text-gray-800">
            {{ $category->name }}
        </h2>

        <!-- Subcategorías -->
        <div class="flex flex-wrap gap-2">
            @forelse($category->children as $child)
                <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                    {{ $child->name }}
                </span>
            @empty
                <span class="text-gray-400 text-sm">
                    Sin subcategorías
                </span>
            @endforelse
        </div>

        <div class="flex justify-end gap-2 mt-4">

            <!-- Editar -->
            <a href="{{ route('categorias.edit', $category->id) }}"
            class="text-blue-600 text-sm hover:underline">
                Editar
            </a>

            <!-- Eliminar -->
            <form action="{{ route('categorias.destroy', $category->id) }}" method="POST"
                onsubmit="return confirm('¿Eliminar esta categoría?')">
                @csrf
                @method('DELETE')

                <button class="text-red-500 text-sm hover:underline">
                    Eliminar
                </button>
            </form>

        </div>

    </div>
@endforeach

</div>

@endsection
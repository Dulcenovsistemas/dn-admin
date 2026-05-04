@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Editar Categoría
</h1>

<div class="max-w-xl bg-white p-6 rounded-xl shadow">

<form method="POST" action="{{ route('categorias.update', $category->id) }}">
@csrf
@method('PUT')

    <!-- Nombre -->
    <div class="mb-4">
        <label class="block text-sm mb-1">Nombre</label>
        <input name="name" value="{{ $category->name }}"
            class="w-full border p-2 rounded">
    </div>

    <!-- Padre -->
    <div class="mb-4">
        <label class="block text-sm mb-1">Categoría padre</label>
        <select name="parent_id" class="w-full border p-2 rounded">
            <option value="">Categoría principal</option>

            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Actualizar
    </button>

</form>

</div>

<!-- 🔥 SUBCATEGORÍAS -->
<div class="max-w-xl bg-white p-6 rounded-xl shadow mt-6">

    <h2 class="text-lg font-semibold mb-4">
        Subcategorías
    </h2>

    @forelse($category->children as $child)
        <div class="flex justify-between items-center border-b py-2">

            <span class="text-gray-700">
                {{ $child->name }}
            </span>

            <form action="{{ route('categorias.destroy', $child->id) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar subcategoría?')">
                @csrf
                @method('DELETE')

                <button class="text-red-500 text-sm hover:underline">
                    Eliminar
                </button>
            </form>

        </div>
    @empty
        <p class="text-gray-400 text-sm">
            No hay subcategorías
        </p>
    @endforelse

</div>

@endsection
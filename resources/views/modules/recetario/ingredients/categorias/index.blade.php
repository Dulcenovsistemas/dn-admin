@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-bold mb-6">Categorías</h1>

{{-- 🔹 Crear categoría --}}
<form method="POST" action="{{ route('categorias.store') }}" class="mb-8 flex gap-2">
    @csrf
    <input type="text" name="nombre" placeholder="Nueva categoría"
           class="border p-2 rounded w-64">
    <button type="submit" class="bg-black text-white px-4 rounded">
        Guardar
    </button>
</form>

{{-- 🔥 GRID DE CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach($categorias as $categoria)

        <div class="bg-white shadow-md rounded-xl p-4 relative hover:shadow-lg transition">

            {{-- 🗑️ Botón eliminar --}}
            <form method="POST"
                  action="{{ route('categorias.destroy', $categoria->id) }}"
                  onsubmit="return confirm('¿Eliminar esta categoría y sus subcategorías?')"
                  class="absolute top-2 right-2">

                @csrf
                @method('DELETE')

                <button type="submit"
                    class="px-2 py-1 text-xs rounded-md 
                        bg-red-500 text-white 
                        hover:bg-red-600 transition">
                    Eliminar
                </button>
            </form>

            {{-- 🧱 Nombre categoría --}}
            <h2 class="font-bold text-lg mb-2 pr-6">
                {{ $categoria->nombre }}
            </h2>

            {{-- 🔹 Subcategorías --}}
            <div class="mb-3">
                @forelse($categoria->subcategorias as $sub)
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-1">

                        <span>• {{ $sub->nombre }}</span>

                        <form method="POST"
                            action="{{ route('subcategorias.destroy', $sub->id) }}"
                            onsubmit="return confirm('¿Eliminar esta subcategoría?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-400 hover:text-red-600 text-xs">
                                ✕
                            </button>
                        </form>

                    </div>
                @empty
                    <div class="text-sm text-gray-400 italic">
                        Sin subcategorías
                    </div>
                @endforelse
            </div>

            {{-- ➕ Agregar subcategoría --}}
            <form method="POST"
                  action="{{ route('subcategorias.store') }}"
                  class="flex gap-2 mt-3">

                @csrf
                <input type="hidden" name="categoria_id" value="{{ $categoria->id }}">

                <input type="text"
                       name="nombre"
                       placeholder="Nueva sub"
                       class="border p-1 rounded w-full text-sm">

                <button type="submit"
                        class="bg-gray-800 text-white px-2 rounded text-sm">
                    +
                </button>
            </form>

        </div>

    @endforeach

</div>

@endsection
<div class="ml-{{ $level ?? 0 }} mb-2">

    <div class="flex items-center justify-between bg-gray-50 p-2 rounded">

        <span class="font-medium">
            {{ $category->name }}
        </span>

        <form method="POST" action="{{ route('categorias.destroy', $category->id) }}"
              onsubmit="return confirm('¿Eliminar categoría?')">
            @csrf
            @method('DELETE')

            <button class="text-red-500 text-sm">
                ✕
            </button>
        </form>

    </div>

    {{-- hijos --}}
    @foreach($category->children as $child)
        @include('modules.recetario.ingredients.categories.partials.node', [
            'category' => $child,
            'level' => ($level ?? 0) + 4
        ])
    @endforeach

</div>
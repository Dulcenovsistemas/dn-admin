@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
    Nueva Categoría / Subcategoría
</h1>

<div class="max-w-xl bg-white p-6 rounded-xl shadow">

<form method="POST" action="{{ route('categorias.store') }}">
@csrf

    <!-- Nombre -->
    <div class="mb-4">
        <label class="block text-sm text-gray-600 mb-1">
            Nombre
        </label>

        <input name="name" 
            placeholder="Ej: Pan, Chico, Grande..."
            class="w-full border p-2 rounded">
    </div>

    <!-- Tipo -->
    <div class="mb-4">
        <label class="block text-sm text-gray-600 mb-1">
            Tipo
        </label>

        <select id="type" class="w-full border p-2 rounded">
            <option value="category">Categoría</option>
            <option value="subcategory">Subcategoría</option>
        </select>
    </div>

    <!-- Categoría padre -->
    <div class="mb-4 hidden" id="parentContainer">
        <label class="block text-sm text-gray-600 mb-1">
            Categoría padre
        </label>

        <select name="parent_id" class="w-full border p-2 rounded">
            <option value="">Seleccionar categoría</option>

            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Botón -->
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Guardar
    </button>

</form>

</div>

<!-- Script -->
<script>
    const typeSelect = document.getElementById('type');
    const parentContainer = document.getElementById('parentContainer');

    typeSelect.addEventListener('change', function () {
        if (this.value === 'subcategory') {
            parentContainer.classList.remove('hidden');
        } else {
            parentContainer.classList.add('hidden');
        }
    });
</script>

@endsection
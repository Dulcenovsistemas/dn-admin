@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Nuevo Item
</h1>

<div class="max-w-xl bg-white p-6 rounded-xl shadow">

<form method="POST" action="{{ route('items.store') }}">
@csrf

    <!-- Nombre -->
    <div class="mb-4">
        <label class="block text-sm mb-1">Nombre</label>
        <input name="name" class="w-full border p-2 rounded">
    </div>

    <!-- Tipo -->
    <div class="mb-4">
        <label class="block text-sm mb-1">Tipo</label>
        <select name="type" class="w-full border p-2 rounded">
            <option value="ingredient">Ingrediente</option>
            <option value="product">Producto</option>
        </select>
    </div>

    <!-- Categoría -->
    <div class="mb-4">
        <label class="block text-sm mb-1">Categoría</label>
        <select name="category_id" id="category_id" class="w-full border p-2 rounded">
            <option value="">Seleccionar</option>

            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Subcategoría -->
    <div class="mb-4">
        <label class="block text-sm mb-1">Subcategoría</label>
        <select name="subcategory_id" id="subcategory_id" class="w-full border p-2 rounded" disabled>
            <option value="">Selecciona una categoría primero</option>
        </select>
    </div>

    <!-- Unidad -->
    <div class="mb-4">
        <label class="block text-sm mb-1">Unidad</label>
        <select name="unit" class="w-full border p-2 rounded">
            <option value="KG">KG</option>
            <option value="LT">LT</option>
            <option value="PZ">PZ</option>
        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Guardar
    </button>

</form>

</div>

<script>
    const subcategories = @json($subcategories);

    const categorySelect = document.getElementById('category_id');
    const subcategorySelect = document.getElementById('subcategory_id');

    categorySelect.addEventListener('change', function () {
        const categoryId = this.value;

        // Reset
        subcategorySelect.innerHTML = '';
        subcategorySelect.disabled = true;

        if (!categoryId) {
            subcategorySelect.innerHTML = '<option>Selecciona una categoría primero</option>';
            return;
        }

        // Filtrar subcategorías
        const filtered = subcategories.filter(sub => sub.parent_id == categoryId);

        if (filtered.length === 0) {
            subcategorySelect.innerHTML = '<option>Sin subcategorías</option>';
            return;
        }

        subcategorySelect.disabled = false;

        filtered.forEach(sub => {
            const option = document.createElement('option');
            option.value = sub.id;
            option.textContent = sub.name;
            subcategorySelect.appendChild(option);
        });
    });
</script>

@endsection
@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Categorías</h1>

{{-- ➕ Crear categoría --}}
<form method="POST" action="{{ route('categorias.store') }}" class="mb-6 flex gap-2">
    @csrf

    <input type="text" name="name"
        placeholder="Nueva categoría"
        class="border p-2 rounded w-64">

    <select name="parent_id" class="border p-2 rounded">
        <option value="">Sin padre</option>

        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>

    <button class="bg-blue-600 text-white px-4 rounded">
        Guardar
    </button>
</form>

{{-- 🌳 Árbol --}}
<div class="bg-white rounded-xl shadow p-4">

    @foreach($categories as $category)
        @include('modules.recetario.ingredients.categories.partials.node', ['category' => $category])
    @endforeach

</div>

@endsection
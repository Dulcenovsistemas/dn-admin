@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Recetario
</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Ingredientes -->
    <a href="{{ route('items.index') }}"
    class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
        <h2 class="font-semibold text-lg">Ingredientes</h2>
        <p class="text-sm text-gray-500">Administrar ingredientes</p>
    </a>

    <!-- Categorías -->
    <a href="{{ route('categorias.index') }}" 
    class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
        <h2 class="font-semibold text-lg">Categorías</h2>
        <p class="text-sm text-gray-500">Tipos de productos</p>
    </a>

    <!-- Subcategorías -->
    <a href="" 
    class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
        <h2 class="font-semibold text-lg">Subcategorías</h2>
        <p class="text-sm text-gray-500">Tamaños / variantes</p>
    </a>

    <!-- Recetas -->
    <a href="" 
    class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
        <h2 class="font-semibold text-lg">Recetas</h2>
        <p class="text-sm text-gray-500">Construcción de productos</p>
    </a>

</div>

@endsection
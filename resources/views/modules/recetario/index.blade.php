@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Recetario
</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('ingredientes.index') }}" 
        class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
        Ingredientes
        </h2>

        <p class="text-sm text-gray-500">
        Administrar ingredientes
        </p>

        </a>


        <a href="/recetas" 
        class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
        Recetas
        </h2>

        <p class="text-sm text-gray-500">
        Administrar recetas
        </p>

        </a>

    </div>

@endsection
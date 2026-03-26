@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Mantenimiento
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- EQUIPOS --}}
    <a href="{{ route('equipos.index') }}" 
       class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
            Equipos
        </h2>

        <p class="text-sm text-gray-500">
            Gestión de equipos
        </p>

    </a>


    {{-- SERVICIOS --}}
    <a href="#" 
       class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
            Servicios
        </h2>

        <p class="text-sm text-gray-500">
            Catálogo de servicios
        </p>

    </a>


    {{-- ÓRDENES --}}
    <a href="#" 
       class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
            Órdenes
        </h2>

        <p class="text-sm text-gray-500">
            Órdenes de mantenimiento
        </p>

    </a>


    {{-- BITÁCORA --}}
    <a href="#" 
       class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
            Bitácora
        </h2>

        <p class="text-sm text-gray-500">
            Historial de actividades
        </p>

    </a>


    {{-- MANTENIMIENTOS --}}
    <a href="#" 
       class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
            Mantenimientos
        </h2>

        <p class="text-sm text-gray-500">
            Seguimiento de mantenimientos
        </p>

    </a>

</div>

@endsection
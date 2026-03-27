

@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-2">
    {{ $sucursal->name }}
</h1>

<p class="text-gray-500 mb-6">
    Selecciona un área
</p>

<div class="mb-6">
    <a href="{{ route('equipos.index') }}" 
       class="text-blue-600 hover:underline text-sm">
        ← Volver a sucursales
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($sucursal->areas as $area)
    <a href="{{ route('equipos.area', $area->id) }}">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition cursor-pointer">

            <h2 class="font-semibold text-lg mb-2">
                {{ $area->name }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ $area->equipos->count() }} equipos
            </p>

        </div>
    </a>
    @endforeach

</div>

@endsection
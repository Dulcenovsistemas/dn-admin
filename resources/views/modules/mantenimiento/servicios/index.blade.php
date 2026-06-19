@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
    Servicios
</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($sucursales as $sucursal)

        <a href="{{ route('servicios.sucursal', $sucursal->id) }}"
           class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition">

            <h2 class="text-lg font-semibold text-gray-800">
                {{ $sucursal->name }}
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                {{ $sucursal->areas->count() }} áreas
            </p>

        </a>

    @empty

        <div class="col-span-full bg-white rounded-xl p-6 text-center text-gray-400">
            No tienes sucursales asignadas
        </div>

    @endforelse

</div>

@endsection
@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Equipos
</h1>

<div class="mb-6">
    <a href="{{ route('equipos.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Crear equipo
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($equipos as $equipo)
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg mb-2">
            {{ $equipo->nombre }}
        </h2>

        <p class="text-sm text-gray-500">
            ID: {{ $equipo->id }}
        </p>

        <p class="text-sm text-gray-500">
            {{ $equipo->sucursal->name }} - {{ $equipo->area->name }}
        </p>

        <p class="text-sm text-gray-500 mt-2">
            {{ $equipo->marca_modelo }}
        </p>

        <div class="flex justify-between items-center mt-4">

            <a href="{{ route('equipos.show', $equipo->id) }}"
               class="text-blue-600 hover:underline text-sm">
                Ver
            </a>

            <a href="{{ route('equipos.edit', $equipo->id) }}"
               class="text-blue-600 hover:underline text-sm">
                Editar
            </a>

            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button onclick="return confirm('¿Eliminar este equipo?')"
                        class="text-red-500 hover:underline text-sm">
                    Eliminar
                </button>
            </form>

        </div>

    </div>
    @endforeach

</div>

@endsection
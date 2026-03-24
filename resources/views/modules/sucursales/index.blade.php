@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Sucursales
</h1>

<div class="mb-6">
    <a href="{{ route('branches.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Crear sucursal
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($branches as $branch)
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg mb-2">
            {{ $branch->nombre }}
        </h2>

        <p class="text-sm text-gray-500 mb-4">
            Administrar sucursal
        </p>

        <div class="flex justify-between items-center">

            <a href="{{ route('branches.edit', $branch->id) }}"
               class="text-blue-600 hover:underline text-sm">
                Editar
            </a>

            <form action="{{ route('branches.destroy', $branch->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="text-red-500 hover:underline text-sm">
                    Eliminar
                </button>
            </form>

        </div>

    </div>
    @endforeach

</div>

@endsection
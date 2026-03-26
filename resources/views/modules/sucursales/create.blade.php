@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Crear Sucursal
</h1>

<form method="POST" action="{{ route('sucursales.store') }}">
    @csrf

    <div class="bg-white p-6 rounded-xl shadow w-full md:w-1/2">

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">
                Nombre de la sucursal
            </label>

            <input type="text" name="name"
                   class="w-full border rounded p-2"
                   placeholder="Ej. Sucursal Centro">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">
                Ciudad
            </label>

            <input type="text" name="city"
                   class="w-full border rounded p-2"
                   placeholder="Ej. Chihuahua">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Guardar
        </button>

    </div>

</form>

@endsection
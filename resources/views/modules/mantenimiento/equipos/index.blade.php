@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
    Equipos
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($sucursales as $sucursal)
    <a href="{{ route('equipos.sucursal', $sucursal->id) }}">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition cursor-pointer">

            <h2 class="font-semibold text-lg mb-2">
                {{ $sucursal->name }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ $sucursal->areas->count() }} áreas
            </p>

        </div>
    </a>
    @endforeach

</div>

@endsection
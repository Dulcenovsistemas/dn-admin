@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Mantenimiento
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Empleados --}}
    @if(auth()->user()->hasModulePermission('empleados','view'))
        <a href="{{ route('employees.index') }}" 
        class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

            <h2 class="font-semibold text-lg">
                Empleados
            </h2>

            <p class="text-sm text-gray-500">
                Gestión de Empleados
            </p>

        </a>
    @endif


    @if(auth()->user()->hasModulePermission('vacaciones','view'))
        {{-- Vacaciones --}}
        <a href="{{ route('vacations.index') }}"
        class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

            <h2 class="font-semibold text-lg">
                Vacaciones
            </h2>

            <p class="text-sm text-gray-500">
                Calculadora de dìas, gestion de periodos.
            </p>

        </a>
    @endif


    {{-- EXPEDIENTES --}}
    <a href="#" 
       class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">

        <h2 class="font-semibold text-lg">
            Expedientes medicos
        </h2>

        <p class="text-sm text-gray-500">
            Gestion de expedientes medicos por empleado
        </p>

    </a>

    <form action="{{ route('checadas.importar') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf

        <input type="file" name="archivo">

        <button type="submit">
            Importar
        </button>
    </form>


</div>

@endsection
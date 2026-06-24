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

    <div class="max-w-xl mx-auto mt-10">

    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">

        <h1 class="text-2xl font-bold text-slate-800 mb-2">
            Importar Checadas
        </h1>

        <p class="text-slate-500 mb-6">
            Selecciona el archivo de asistencia generado por el reloj checador.
        </p>

        <form action="{{ route('checadas.importar') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Archivo Excel
                </label>

                <input type="file"
                       name="archivo"
                       required
                       accept=".xls,.xlsx"
                       class="block w-full text-sm text-slate-600
                              file:mr-4
                              file:py-2
                              file:px-4
                              file:rounded-xl
                              file:border-0
                              file:bg-blue-600
                              file:text-white
                              file:font-medium
                              hover:file:bg-blue-700
                              cursor-pointer">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700
                           text-white font-semibold
                           py-3 rounded-xl
                           transition duration-200">

                📊 Generar Reporte de Checadas

            </button>

        </form>

    </div>

</div>

</div>

@endsection
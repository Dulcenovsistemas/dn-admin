@extends('layouts.erp')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Vacaciones</h1>
            <p class="text-sm text-gray-500">Consulta empleados y programa sus vacaciones</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 mb-6">
        <form method="GET" action="{{ route('vacations.index') }}" class="flex flex-col md:flex-row gap-3 md:items-end">
            <div class="w-full md:max-w-md">
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar empleado</label>
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Nombre, apellido o número de empleado"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-24 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    <button
                        type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition"
                    >
                        Buscar
                    </button>
                </div>
            </div>

            @if(!empty($search))
                <a href="{{ route('vacations.index') }}"
                   class="inline-flex items-center justify-center px-4 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Lista de empleados</h2>
                    <p class="text-sm text-gray-500">
                        {{ $employees->count() }} resultado(s)
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Empleado</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha ingreso</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Acción</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">
                                        {{ $employee->name }} {{ $employee->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        No. {{ $employee->employee_number ?? 'N/D' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center text-gray-700">
                                    {{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                        <a href="{{ route('vacations.create', $employee->id) }}"
                                        class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-xl transition">
                                            Programar vacaciones
                                        </a>

                                        <a href="{{ route('vacations.periods', $employee->id) }}"
                                        class="inline-flex items-center justify-center bg-gray-800 hover:bg-gray-900 text-white font-medium px-4 py-2 rounded-xl transition">
                                            Ver periodos
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                    No se encontraron empleados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
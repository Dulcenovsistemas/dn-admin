@extends('layouts.erp')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Vacaciones
            </h1>

            <p class="text-sm text-gray-500">
                Gestión y cálculo de periodos vacacionales
            </p>

        </div>

    </div>

    {{-- CALCULADORA --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">

        <div class="mb-6">

            <h2 class="text-lg font-semibold text-gray-800">
                Calculadora de vacaciones
            </h2>

            <p class="text-sm text-gray-500">
                Selecciona un empleado para calcular su periodo vacacional
            </p>

        </div>

        <form action="{{ route('vacations.index') }}" method="GET">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- EMPLEADO --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Empleado
                    </label>

                    <select
                        name="employee_id"
                        onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                        <option value="">
                            Selecciona un empleado
                        </option>

                        @foreach($employees as $employee)

                            <option
                                value="{{ $employee->id }}"
                                {{ request('employee_id') == $employee->id ? 'selected' : '' }}
                            >
                                {{ $employee->name }}
                                {{ $employee->last_name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- FECHA INGRESO --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha de ingreso
                    </label>

                    <input
                        type="text"
                        readonly
                        value="{{ $selectedEmployee?->hire_date ? \Carbon\Carbon::parse($selectedEmployee->hire_date)->format('d/m/Y') : '' }}"
                        class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-3 text-gray-700"
                    />

                </div>

                {{-- FECHA BASE --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha base
                    </label>

                    <input
                        type="date"
                        name="current_date"
                        value="{{ request('current_date', now()->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                </div>

                {{-- DÍAS TOMADOS --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Días tomados
                    </label>

                    <input
                        type="number"
                        name="taken_days"
                        min="0"
                        value="{{ request('taken_days', 0) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >

                </div>

            </div>

            {{-- BOTONES --}}
            <div class="flex items-center gap-3 mt-6">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-xl transition"
                >
                    Calcular periodo
                </button>

                @isset($result)

                    <button
                        type="button"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-xl transition"
                    >
                        Guardar periodo
                    </button>

                @endisset

            </div>

        </form>

        {{-- RESULTADO --}}
        @isset($result)

            <div class="mt-8 border-t border-gray-200 pt-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-5">
                    Resultado del cálculo
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    {{-- ANTIGÜEDAD --}}
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">

                        <p class="text-sm text-gray-500 mb-1">
                            Antigüedad
                        </p>

                        <p class="text-3xl font-bold text-gray-800">
                            {{ $result['years_of_service'] }}
                        </p>

                        <p class="text-sm text-gray-500">
                            años
                        </p>

                    </div>

                    {{-- PERIODO --}}
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">

                        <p class="text-sm text-gray-500 mb-1">
                            Periodo actual
                        </p>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $result['period_start'] }}
                        </p>

                        <p class="text-sm text-gray-500">
                            al {{ $result['period_end'] }}
                        </p>

                    </div>

                    {{-- OTORGADOS --}}
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">

                        <p class="text-sm text-gray-500 mb-1">
                            Días otorgados
                        </p>

                        <p class="text-3xl font-bold text-blue-600">
                            {{ $result['entitled_days'] }}
                        </p>

                    </div>

                    {{-- DISPONIBLES --}}
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">

                        <p class="text-sm text-gray-500 mb-1">
                            Días disponibles
                        </p>

                        <p class="text-3xl font-bold text-green-600">
                            {{ $result['available_days'] }}
                        </p>

                    </div>

                </div>

            </div>

        @endisset

    </div>

    {{-- HISTORIAL --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200">

            <h2 class="text-lg font-semibold text-gray-800">
                Historial de periodos
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Empleado
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                            Antigüedad
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                            Periodo
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                            Otorgados
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                            Disponibles
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                            Estado
                        </th>

                    </tr>

                </thead>

                <tbody class="bg-white divide-y divide-gray-100">

                    @foreach($employees as $employee)

                        @php
                            $period = $employee->activeVacationPeriod;
                        @endphp

                        <tr class="hover:bg-gray-50 transition">

                            {{-- EMPLEADO --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-800">
                                    {{ $employee->name }}
                                    {{ $employee->last_name }}
                                </div>

                            </td>

                            {{-- ANTIGÜEDAD --}}
                            <td class="px-6 py-4 text-center text-gray-700">

                                {{ $period?->years_of_service ?? 0 }} años

                            </td>

                            {{-- PERIODO --}}
                            <td class="px-6 py-4 text-center text-sm text-gray-700">

                                @if($period)

                                    {{ \Carbon\Carbon::parse($period->period_start)->format('d/m/Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($period->period_end)->format('d/m/Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            {{-- OTORGADOS --}}
                            <td class="px-6 py-4 text-center font-medium text-gray-700">

                                {{ $period?->entitled_days ?? 0 }}

                            </td>

                            {{-- DISPONIBLES --}}
                            <td class="px-6 py-4 text-center">

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">

                                    {{ $period?->available_days ?? 0 }}

                                </span>

                            </td>

                            {{-- ESTADO --}}
                            <td class="px-6 py-4 text-center">

                                @if($period?->status === 'open')

                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                        Activo
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                        Cerrado
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
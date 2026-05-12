@extends('layouts.erp')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Vacaciones
            </h1>

            <p class="text-sm text-gray-500">
                Gestión de periodos y días disponibles
            </p>

        </div>

    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                {{-- Head --}}
                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Empleado
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Antigüedad
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Periodo
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Días otorgados
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Tomados
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Pendientes
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Disponibles
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>

                    </tr>

                </thead>

                {{-- Body --}}
                <tbody class="bg-white divide-y divide-gray-100">

                    @foreach($employees as $employee)

                        @php
                            $period = $employee->activeVacationPeriod;
                        @endphp

                        <tr class="hover:bg-gray-50 transition">

                            {{-- Empleado --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="font-medium text-gray-800">
                                    {{ $employee->name }}
                                    {{ $employee->last_name }}
                                </div>

                            </td>

                            {{-- Antigüedad --}}
                            <td class="px-6 py-4 text-center text-gray-700">

                                {{ $period?->years_of_service ?? 0 }}

                                años

                            </td>

                            {{-- Periodo --}}
                            <td class="px-6 py-4 text-center text-gray-700 text-sm">

                                @if($period)

                                    {{ \Carbon\Carbon::parse($period->period_start)->format('d/m/Y') }}

                                    -

                                    {{ \Carbon\Carbon::parse($period->period_end)->format('d/m/Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            {{-- Otorgados --}}
                            <td class="px-6 py-4 text-center text-gray-700 font-medium">

                                {{ $period?->entitled_days ?? 0 }}

                            </td>

                            {{-- Tomados --}}
                            <td class="px-6 py-4 text-center text-red-600 font-medium">

                                {{ $period?->taken_days ?? 0 }}

                            </td>

                            {{-- Pendientes --}}
                            <td class="px-6 py-4 text-center text-yellow-600 font-medium">

                                {{ $period?->pending_days ?? 0 }}

                            </td>

                            {{-- Disponibles --}}
                            <td class="px-6 py-4 text-center">

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">

                                    {{ $period?->available_days ?? 0 }}

                                </span>

                            </td>

                            {{-- Estado --}}
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

                            {{-- Acciones --}}
                            <td class="px-6 py-4 text-center">

                                <a
                                    href="#"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition"
                                >
                                    Ver
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
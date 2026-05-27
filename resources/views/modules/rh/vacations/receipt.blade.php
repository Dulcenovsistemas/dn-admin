@extends('layouts.erp')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Recibo de vacaciones</h1>
            <p class="text-sm text-gray-500">Documento para firma e impresión</p>
        </div>

        <button onclick="window.print()"
                class="rounded-xl bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
            Imprimir
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8">
        <div class="text-center border-b pb-5 mb-6">
            <h2 class="text-2xl font-bold">RECIBO DE VACACIONES</h2>
            <p class="text-gray-500">Registro de periodo vacacional y pago correspondiente</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Empleado</p>
                <p class="font-semibold text-gray-800">{{ $vacation->employee->name }} {{ $vacation->employee->last_name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Número de empleado</p>
                <p class="font-semibold text-gray-800">{{ $vacation->employee->employee_number ?? $vacation->employee->id }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Fecha de ingreso</p>
                <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($vacation->employee->hire_date)->format('d/m/Y') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Periodo vacacional</p>
                <p class="font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($vacation->start_date)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($vacation->end_date)->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Días disponibles</p>
                <p class="font-semibold text-gray-800">{{ $vacation->available_days }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Días tomados</p>
                <p class="font-semibold text-gray-800">{{ $vacation->taken_days }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Saldo restante</p>
                <p class="font-semibold text-gray-800">{{ $vacation->balance_days }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Sueldo diario</p>
                <p class="font-semibold text-gray-800">${{ number_format($vacation->salary_daily, 2) }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Pago de vacaciones</p>
                <p class="font-semibold text-gray-800">${{ number_format($vacation->vacation_pay, 2) }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Prima vacacional (25%)</p>
                <p class="font-semibold text-gray-800">${{ number_format($vacation->prima_vacacional, 2) }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Total a pagar</p>
                <p class="text-2xl font-bold text-green-700">${{ number_format($vacation->total_pay, 2) }}</p>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="text-center pt-16">
                <div class="border-t border-gray-400"></div>
                <p class="mt-2 text-sm text-gray-600">Firma del empleado</p>
            </div>

            <div class="text-center pt-16">
                <div class="border-t border-gray-400"></div>
                <p class="mt-2 text-sm text-gray-600">Firma de Recursos Humanos</p>
            </div>
        </div>
    </div>
</div>
@endsection
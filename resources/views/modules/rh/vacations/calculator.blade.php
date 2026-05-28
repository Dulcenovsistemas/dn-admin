@extends('layouts.erp')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Programar vacaciones</h1>
            <p class="text-sm text-gray-500">Calcula el periodo vacacional y el pago correspondiente</p>
        </div>

        <a href="{{ route('vacations.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
            Volver a la lista
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-semibold mb-2">Revisa los campos:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $lastVacation = $employee->activeVacationPeriod ?? null;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- FORMULARIO PRINCIPAL --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Datos del empleado</h2>
                    <p class="text-sm text-gray-500">Estos datos vienen cargados automáticamente</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Número de empleado</label>
                        <input
                            type="text"
                            value="{{ $employee->employee_number ?? $employee->id }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del empleado</label>
                        <input
                            type="text"
                            value="{{ $employee->name }} {{ $employee->last_name }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de ingreso</label>
                        <input
                            type="text"
                            value="{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Últimas vacaciones</label>
                        <input
                            type="text"
                            value="{{ $lastVacation ? \Carbon\Carbon::parse($lastVacation->period_start)->format('d/m/Y').' - '.\Carbon\Carbon::parse($lastVacation->period_end)->format('d/m/Y') : 'Sin registro' }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700"
                        >
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Periodo y cálculo</h2>
                    <p class="text-sm text-gray-500">Captura lo manual y el sistema hace el resto</p>
                </div>

                <form action="{{ route('vacations.store') }}" method="POST" class="p-6">
                    @csrf

                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de inicio</label>
                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('start_date') }}"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de fin</label>
                            <input
                                type="date"
                                name="end_date"
                                id="end_date"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('end_date') }}"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Días disponibles</label>
                            <input
                                type="number"
                                min="0"
                                step="1"
                                name="available_days"
                                id="available_days"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('available_days', $lastVacation?->available_days ?? 16) }}"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Días tomados</label>
                            <input
                                type="number"
                                min="0"
                                step="1"
                                name="taken_days"
                                id="taken_days"
                                readonly
                                class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700"
                                value="0"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Saldo restante</label>
                            <input
                                type="text"
                                id="balance_days"
                                readonly
                                class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700"
                                value="0"
                            >
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sueldo diario</label>
                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                name="salary_daily"
                                id="salary_daily"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none"
                                value="{{ old('salary_daily', $employee->salary_daily ?? 500) }}"
                            >
                        </div>

                        <div class="flex items-end">
                            <div class="w-full rounded-xl border border-gray-200 bg-blue-50 px-4 py-3">
                                <p class="text-sm text-gray-600">Prima vacacional fija</p>
                                <p class="text-2xl font-bold text-blue-700">25%</p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="vacation_pay" id="vacation_pay_input" value="">
                    <input type="hidden" name="prima_vacacional" id="prima_vacacional_input" value="">
                    <input type="hidden" name="total_pay" id="total_pay_input" value="">

                    <div class="mt-8 hidden" id="resultSection">
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-5">Resultado del cálculo</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                    <p class="text-sm text-gray-500 mb-1">Pago de vacaciones</p>
                                    <p class="text-3xl font-bold text-gray-800" id="vacation_pay">0.00</p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                    <p class="text-sm text-gray-500 mb-1">Prima vacacional</p>
                                    <p class="text-3xl font-bold text-blue-600" id="prima_vacacional">0.00</p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                    <p class="text-sm text-gray-500 mb-1">Total a pagar</p>
                                    <p class="text-3xl font-bold text-green-600" id="total_pay">0.00</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-6 py-3 font-medium text-white hover:bg-emerald-700 transition"
                                >
                                    Guardar periodo
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- PANEL LATERAL --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Resumen rápido</h2>
                </div>

                <div class="p-6 space-y-4">
                    <div class="rounded-2xl bg-slate-900 p-4 text-white">
                        <p class="text-xs uppercase tracking-wider text-slate-300">Empleado</p>
                        <p class="mt-1 font-semibold">{{ $employee->name }} {{ $employee->last_name }}</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wider text-gray-400">Fecha de ingreso</p>
                        <p class="mt-1 font-semibold text-gray-800">{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 p-4 border border-gray-100">
                        <p class="text-xs uppercase tracking-wider text-gray-400">Último periodo</p>
                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $lastVacation ? \Carbon\Carbon::parse($lastVacation->period_start)->format('d/m/Y').' - '.\Carbon\Carbon::parse($lastVacation->period_end)->format('d/m/Y') : 'Sin registro' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-blue-50 p-4 border border-blue-100">
                        <p class="text-sm text-blue-800">
                            Captura los días disponibles, los días tomados y el sueldo diario. Al presionar calcular, se generan el pago de vacaciones, la prima vacacional y el total.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function money(value) {
        return new Intl.NumberFormat('es-MX', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value);
    }

   function calculateDays() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (!startDate || !endDate) {
            return 0;
        }

        const start = new Date(startDate);
        const end = new Date(endDate);

        if (end < start) {
            return 0;
        }

        let count = 0;

        // Crear copia para no modificar start
        let currentDate = new Date(start);

        while (currentDate <= end) {

            // 0 = Domingo
            if (currentDate.getDay() !== 0) {
                count++;
            }

            currentDate.setDate(currentDate.getDate() + 1);
        }

        return count;
    }

    function calculateVacations() {

        const availableDays = parseFloat(document.getElementById('available_days').value) || 0;
        const salaryDaily = parseFloat(document.getElementById('salary_daily').value) || 0;

        const takenDays = calculateDays();

        document.getElementById('taken_days').value = takenDays;

        const balanceDays = availableDays - takenDays;

        const vacationPay = salaryDaily * takenDays;

        const primaVacacional = vacationPay * 0.25;

        const totalPay = vacationPay + primaVacacional;

        document.getElementById('balance_days').value = balanceDays;

        document.getElementById('vacation_pay').textContent = money(vacationPay);

        document.getElementById('prima_vacacional').textContent = money(primaVacacional);

        document.getElementById('total_pay').textContent = money(totalPay);

        document.getElementById('vacation_pay_input').value = vacationPay.toFixed(2);

        document.getElementById('prima_vacacional_input').value = primaVacacional.toFixed(2);

        document.getElementById('total_pay_input').value = totalPay.toFixed(2);

        document.getElementById('resultSection').classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {

        [
            'start_date',
            'end_date',
            'available_days',
            'salary_daily'
        ].forEach(function (id) {

            const el = document.getElementById(id);

            if (el) {
                el.addEventListener('input', calculateVacations);
                el.addEventListener('change', calculateVacations);
            }
        });

        calculateVacations();
    });
</script>
@endsection
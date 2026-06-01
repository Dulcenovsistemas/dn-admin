@extends('layouts.erp')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Editar vacaciones</h1>
            <p class="text-sm text-gray-500">
                {{ $vacation->employee->name }} {{ $vacation->employee->last_name }}
            </p>
        </div>

        <a href="{{ route('vacations.receipt', $vacation->id) }}"
           class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
            Volver al recibo
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Datos del empleado</h2>
                    <p class="text-sm text-gray-500">Información cargada automáticamente</p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Número de empleado</label>
                        <input type="text"
                            value="{{ $vacation->employee->employee_number ?? $vacation->employee->id }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del empleado</label>
                        <input type="text"
                            value="{{ $vacation->employee->name }} {{ $vacation->employee->last_name }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de ingreso</label>
                        <input type="text"
                            value="{{ \Carbon\Carbon::parse($vacation->employee->hire_date)->format('d/m/Y') }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Año de vacaciones</label>
                        <input type="text"
                            value="{{ $vacation->vacation_year == 1 ? 'Primer año' : $vacation->vacation_year . '° año' }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Periodo y cálculo</h2>
                    <p class="text-sm text-gray-500">Modifica los datos y se recalculará automáticamente</p>
                </div>

                <form action="{{ route('vacations.update', $vacation->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="employee_id" value="{{ $vacation->employee_id }}">

                    <div>
                        <label for="vacation_year" class="block font-medium mb-1">Año de vacaciones</label>
                        <select name="vacation_year" id="vacation_year" class="w-full border rounded-lg p-2" required>
                            <option value="">Selecciona un año</option>
                            @for ($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}" {{ old('vacation_year', $vacation->vacation_year) == $i ? 'selected' : '' }}>
                                    {{ $i }}° año
                                </option>
                            @endfor
                        </select>
                        @error('vacation_year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <br>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de inicio</label>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ old('start_date', $vacation->start_date) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de fin</label>
                            <input type="date" name="end_date" id="end_date"
                                value="{{ old('end_date', $vacation->end_date) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Días disponibles</label>
                            <input type="number" min="0" step="1" name="available_days" id="available_days"
                                value="{{ old('available_days', $vacation->available_days) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Días tomados</label>
                            <input type="number" min="0" step="1" name="taken_days" id="taken_days" readonly
                                value="{{ $vacation->taken_days }}"
                                class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Saldo restante</label>
                            <input type="text" id="balance_days" readonly
                                value="{{ $vacation->balance_days }}"
                                class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700">
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sueldo diario</label>
                            <input type="number" min="0" step="0.01" name="salary_daily" id="salary_daily"
                                value="{{ old('salary_daily', $vacation->salary_daily) }}"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-700">
                        </div>

                        <div class="flex items-end">
                            <div class="w-full rounded-xl border border-gray-200 bg-blue-50 px-4 py-3">
                                <p class="text-sm text-gray-600">Prima vacacional fija</p>
                                <p class="text-2xl font-bold text-blue-700">25%</p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="vacation_pay" id="vacation_pay_input">
                    <input type="hidden" name="prima_vacacional" id="prima_vacacional_input">
                    <input type="hidden" name="total_pay" id="total_pay_input">

                    <div class="mt-8" id="resultSection">
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

                            <div class="mt-6 flex gap-3">
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-6 py-3 font-medium text-white hover:bg-emerald-700 transition">
                                    Guardar cambios
                                </button>

                                <a href="{{ route('vacations.receipt', $vacation->id) }}"
                                   class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-6 py-3 font-medium text-gray-700 hover:bg-gray-50 transition">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
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

    function parseLocalDate(dateString) {
        const [year, month, day] = dateString.split('-').map(Number);
        return new Date(year, month - 1, day);
    }

    function calculateDays() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (!startDate || !endDate) return 0;

        const start = parseLocalDate(startDate);
        const end = parseLocalDate(endDate);

        if (end < start) return 0;

        let count = 0;
        let currentDate = new Date(start);

        while (currentDate <= end) {
            if (currentDate.getDay() !== 0) count++;
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
    }

    document.addEventListener('DOMContentLoaded', function () {
        ['start_date', 'end_date', 'available_days', 'salary_daily'].forEach(function (id) {
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
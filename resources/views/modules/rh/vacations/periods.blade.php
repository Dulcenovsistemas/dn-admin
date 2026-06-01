@extends('layouts.erp')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Periodos de vacaciones</h1>
            <p class="text-sm text-gray-500">
                {{ $employee->name }} {{ $employee->last_name }}
            </p>
        </div>

        <a href="{{ route('vacations.index') }}"
           class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
            Volver
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Historial completo</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Inicio</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Fin</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Año</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Días tomados</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Saldo</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Total pagado</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Recibo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($periods as $period)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center">
                                {{ \Carbon\Carbon::parse($period->start_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ \Carbon\Carbon::parse($period->end_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $period->vacation_year == 1 ? '1er Año' : $period->vacation_year . '° Año' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $period->taken_days }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $period->balance_days }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                ${{ number_format($period->total_pay, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('vacations.receipt', $period->id) }}"
                                   class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-xl transition">
                                    Ver recibo
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                Este empleado aún no tiene periodos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
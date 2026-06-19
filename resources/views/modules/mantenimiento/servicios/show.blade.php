@extends('layouts.erp')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-semibold">
                {{ $servicio->nombre }}
            </h1>

            <p class="text-gray-500">
                {{ $servicio->tipo_servicio }}
            </p>
        </div>

        <a href="{{ route('servicios.area', $servicio->area_id) }}"
           class="text-blue-600 hover:underline">
            ← Volver
        </a>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="text-sm text-gray-500">Sucursal</label>
                <p class="font-medium">
                    {{ $servicio->sucursal->name ?? '-' }}
                </p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Área</label>
                <p class="font-medium">
                    {{ $servicio->area->name ?? '-' }}
                </p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Proveedor</label>
                <p class="font-medium">
                    {{ $servicio->proveedor ?? '-' }}
                </p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Contrato</label>
                <p class="font-medium">
                    {{ $servicio->numero_contrato ?? '-' }}
                </p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Costo Mensual</label>
                <p class="font-medium">
                    ${{ number_format($servicio->costo_mensual ?? 0, 2) }}
                </p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Fecha de Inicio</label>
                <p class="font-medium">
                    {{ $servicio->fecha_inicio ?? '-' }}
                </p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Estatus</label>
                <p class="font-medium">
                    {{ $servicio->estatus }}
                </p>
            </div>

        </div>

        <div class="mt-6">

            <label class="text-sm text-gray-500">
                Descripción
            </label>

            <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                {{ $servicio->descripcion ?? 'Sin descripción' }}
            </div>

        </div>

    </div>

</div>

@endsection
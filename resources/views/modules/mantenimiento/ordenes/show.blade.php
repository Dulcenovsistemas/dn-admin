@extends('layouts.erp')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-start">

        <div>

            <div class="flex items-center gap-4">

                <h1 class="text-3xl font-bold">
                    {{ $ordene->folio }}
                </h1>

                @switch($ordene->estado)

                    @case('Pendiente')
                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold">
                            Pendiente
                        </span>
                    @break

                    @case('Asignada')
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                            Asignada
                        </span>
                    @break

                    @case('En proceso')
                        <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-semibold">
                            En proceso
                        </span>
                    @break

                    @case('Finalizada')
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            Finalizada
                        </span>
                    @break

                    @default
                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                            Cancelada
                        </span>

                @endswitch

            </div>

            <p class="text-gray-500 mt-2">
                Orden creada el
                <strong>{{ $ordene->created_at->format('d/m/Y H:i') }}</strong>
            </p>

        </div>

        <a href="{{ route('ordenes.index') }}"
            class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl">

            Regresar

        </a>

        <a
    href="{{ route('reportes.create',$ordene) }}"
    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl inline-block">

    Finalizar trabajo

</a>

    </div>

    {{-- Información General --}}
    <div class="bg-white rounded-2xl shadow">

        <div class="border-b px-8 py-6">

            <h2 class="text-2xl font-bold">
                Información General
            </h2>

            <p class="text-gray-500">
                Datos capturados por el solicitante.
            </p>

        </div>

        <div class="p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div>
                    <p class="text-gray-500 text-sm">Sucursal</p>
                    <p class="font-semibold text-lg">{{ $ordene->sucursal->name }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Área</p>
                    <p class="font-semibold text-lg">{{ $ordene->area->name }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Solicitante</p>
                    <p class="font-semibold text-lg">{{ $ordene->solicitante->name }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Categoría</p>
                    <p class="font-semibold text-lg">{{ $ordene->categoria }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Equipo / Servicio</p>

                    <p class="font-semibold text-lg">

                        @if($ordene->categoria == 'Equipo')

                            {{ optional($ordene->equipo)->nombre }}

                        @else

                            {{ optional($ordene->servicio)->nombre }}

                        @endif

                    </p>

                </div>

                <div>
                    <p class="text-gray-500 text-sm">Tipo</p>
                    <p class="font-semibold text-lg">{{ $ordene->tipo_mantenimiento }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Estado</p>
                    <p class="font-semibold text-lg">{{ $ordene->estado }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Prioridad</p>
                    <p class="font-semibold text-lg">{{ $ordene->prioridad }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">Fecha de creación</p>
                    <p class="font-semibold text-lg">
                        {{ $ordene->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

            </div>

        </div>

    </div>

    {{-- Descripción --}}
    <div class="bg-white rounded-2xl shadow">

        <div class="border-b px-8 py-6">

            <h2 class="text-2xl font-bold">
                Descripción del problema
            </h2>

        </div>

        <div class="p-8">

            <p class="leading-8 text-gray-700">
                {{ $ordene->descripcion }}
            </p>

        </div>

    </div>

    {{-- Información del técnico --}}
    <div class="bg-white rounded-2xl shadow">

        <div class="border-b px-8 py-6">

            <h2 class="text-2xl font-bold">
                Información del técnico
            </h2>

        </div>

        <div class="p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>

                    <p class="text-gray-500 text-sm">
                        Técnico asignado
                    </p>

                    <p class="font-semibold text-lg">
                        {{ optional($ordene->tecnico)->name ?? 'Sin asignar' }}
                    </p>

                    @if(!$ordene->tecnico_id)

                    <form action="{{ route('ordenes.tomar', $ordene) }}" method="POST">

                        @csrf

                        <button
                            class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                            Tomar orden

                        </button>

                    </form>

                    @endif

                </div>

                <div>

                    <p class="text-gray-500 text-sm">
                        Fecha de inicio
                    </p>

                    <p class="font-semibold text-lg">
                        {{ $ordene->fecha_inicio?->format('d/m/Y H:i') ?? 'Sin iniciar' }}
                    </p>

                </div>

                <div>

                    <p class="text-gray-500 text-sm">
                        Fecha de finalización
                    </p>

                    <p class="font-semibold text-lg">
                        {{ $ordene->fecha_fin?->format('d/m/Y H:i') ?? 'Pendiente' }}
                    </p>

                </div>

                <div>

                    <p class="text-gray-500 text-sm">
                        Tiempo trabajado
                    </p>

                    <p class="font-semibold text-lg">
                        —
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Evidencias --}}
<div class="bg-white rounded-2xl shadow">

    <div class="border-b px-8 py-6">

        <h2 class="text-2xl font-bold">
            Evidencias
        </h2>

    </div>

    <div class="p-8">

        @if($ordene->evidencias->count())

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">

                @foreach($ordene->evidencias as $evidencia)

                    <a
                        href="{{ asset('storage/'.$evidencia->archivo) }}"
                        target="_blank"
                        class="group">

                        <img
                            src="{{ asset('storage/'.$evidencia->archivo) }}"
                            alt="Evidencia"
                            class="w-full h-40 object-cover rounded-xl border shadow-sm group-hover:opacity-90 transition">

                    </a>

                @endforeach

            </div>
            


        

        @else

            <p class="text-gray-500">
                No existen evidencias registradas.
            </p>

        @endif

    </div>

</div>

</div>

@endsection
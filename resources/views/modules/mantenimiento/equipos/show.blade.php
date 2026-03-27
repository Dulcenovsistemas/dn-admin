@extends('layouts.erp')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-6">

        <div>
            <h1 class="text-2xl font-semibold text-gray-800">
                {{ $equipo->nombre }}
            </h1>

            <p class="text-sm text-gray-500">
                {{ $equipo->sucursal->name ?? '' }} / {{ $equipo->area->name ?? '' }}
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('equipos.edit', $equipo->id) }}"
               class="px-4 py-2 text-sm bg-gray-100 rounded-lg hover:bg-gray-200">
                Editar
            </a>

            <a href="{{ route('equipos.index') }}"
               class="px-4 py-2 text-sm text-gray-600 hover:text-black">
                Volver
            </a>
        </div>

    </div>

    <div class="grid md:grid-cols-3 gap-6">

        {{-- 📄 INFO DEL EQUIPO --}}
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border p-6">

            <h2 class="text-sm font-semibold text-gray-500 mb-4 uppercase">
                Información general
            </h2>

            <div class="grid grid-cols-2 gap-4 text-sm">

                <div>
                    <span class="text-gray-400">Código</span>
                    <p class="font-medium">{{ $equipo->id }}</p>
                </div>

                <div>
                    <span class="text-gray-400">Marca / Modelo</span>
                    <p class="font-medium">{{ $equipo->marca_modelo ?? '-' }}</p>
                </div>

                <div>
                    <span class="text-gray-400">Número de serie</span>
                    <p class="font-medium">{{ $equipo->numero_serie ?? '-' }}</p>
                </div>

                <div>
                    <span class="text-gray-400">Fecha adquisición</span>
                    <p class="font-medium">{{ $equipo->fecha_adquisicion ?? '-' }}</p>
                </div>

                <div class="col-span-2">
                    <span class="text-gray-400">Responsable</span>
                    <p class="font-medium">{{ $equipo->responsable ?? '-' }}</p>
                </div>

            </div>

            {{-- ESPECIFICACIONES --}}
            <div class="mt-6">
                <span class="text-gray-400 text-sm">Especificaciones</span>

                <div class="mt-2 bg-gray-50 p-4 rounded-lg text-sm whitespace-pre-line">
                    {{ $equipo->especificaciones ?? 'Sin especificaciones' }}
                </div>
            </div>

        </div>

        {{-- 📱 QR --}}
        <div class="bg-white rounded-xl shadow-sm border p-6 text-center">

            <h2 class="text-sm font-semibold text-gray-500 mb-4 uppercase">
                Código QR
            </h2>

            {{-- QR --}}
            <div class="flex justify-center mb-4">
                {!! file_get_contents(public_path($equipo->qr_codigo)) !!}
            </div>

            {{-- BOTONES --}}
            <div class="flex flex-col gap-2">

                {{-- DESCARGAR --}}
                <a href="{{ asset($equipo->qr_codigo) }}" 
                   download
                   class="bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm">
                    Descargar QR
                </a>

                {{-- IMPRIMIR --}}
                <button onclick="window.print()"
                        class="bg-gray-100 py-2 rounded-lg hover:bg-gray-200 text-sm">
                    Imprimir
                </button>

            </div>

        </div>

    </div>

</div>

@endsection
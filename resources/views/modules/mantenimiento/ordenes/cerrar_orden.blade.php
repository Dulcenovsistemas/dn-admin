@extends('layouts.erp')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold">

                Reporte de Servicio

            </h1>

            <p class="text-gray-500 mt-2">

                Orden {{ $ordene->folio }}

            </p>

        </div>

        <a href="{{ route('ordenes.show',$ordene) }}"
           class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl">

            Regresar

        </a>

    </div>

    <form
    action="{{ route('reportes.store', $ordene) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

        {{-- Información de la orden --}}
        <div class="bg-white rounded-2xl shadow">

            <div class="border-b px-8 py-6">

                <h2 class="text-xl font-bold">

                    Información de la orden

                </h2>

            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div>

                    <p class="text-gray-500 text-sm">

                        Sucursal

                    </p>

                    <p class="font-semibold">

                        {{ $ordene->sucursal->name }}

                    </p>

                </div>

                <div>

                    <p class="text-gray-500 text-sm">

                        Área

                    </p>

                    <p class="font-semibold">

                        {{ $ordene->area->name }}

                    </p>

                </div>

                <div>

                    <p class="text-gray-500 text-sm">

                        Solicitante

                    </p>

                    <p class="font-semibold">

                        {{ $ordene->solicitante->name }}

                    </p>

                </div>

                <div>

                    <p class="text-gray-500 text-sm">

                        Equipo / Servicio

                    </p>

                    <p class="font-semibold">

                        @if($ordene->categoria=='Equipo')

                            {{ optional($ordene->equipo)->nombre }}

                        @else

                            {{ optional($ordene->servicio)->nombre }}

                        @endif

                    </p>

                </div>

                <div>

                    <p class="text-gray-500 text-sm">

                        Inicio del trabajo

                    </p>

                    <p class="font-semibold">

                        {{ $ordene->fecha_inicio->format('d/m/Y H:i') }}

                    </p>

                </div>

                <div>

                    <p class="text-gray-500 text-sm">

                        Tiempo transcurrido

                    </p>

                    <p class="font-semibold">

                        {{ $ordene->fecha_inicio->diffForHumans(now(), true) }}

                    </p>

                </div>

            </div>

        </div>

        {{-- Diagnóstico --}}
        <div class="bg-white rounded-2xl shadow">

            <div class="border-b px-8 py-6">

                <h2 class="text-xl font-bold">

                    Diagnóstico

                </h2>

            </div>

            <div class="p-8">

                <textarea
                    name="diagnostico"
                    rows="5"
                    class="w-full rounded-xl border p-4"
                    placeholder="Describe la causa del problema..."></textarea>

            </div>

        </div>

        {{-- Trabajo realizado --}}
        <div class="bg-white rounded-2xl shadow">

            <div class="border-b px-8 py-6">

                <h2 class="text-xl font-bold">

                    Trabajo realizado

                </h2>

            </div>

            <div class="p-8">

                <textarea
                    name="solucion"
                    rows="6"
                    class="w-full rounded-xl border p-4"
                    placeholder="Describe el trabajo realizado..."></textarea>

            </div>

        </div>

        {{-- Materiales --}}
        <div class="bg-white rounded-2xl shadow">

            <div class="border-b px-8 py-6">

                <h2 class="text-xl font-bold">

                    Materiales utilizados

                </h2>

            </div>

            <div class="p-8">

                <textarea
                    name="materiales"
                    rows="4"
                    class="w-full rounded-xl border p-4"
                    placeholder="Materiales o refacciones utilizadas..."></textarea>

            </div>

        </div>

        {{-- Observaciones --}}
        <div class="bg-white rounded-2xl shadow">

            <div class="border-b px-8 py-6">

                <h2 class="text-xl font-bold">

                    Observaciones

                </h2>

            </div>

            <div class="p-8">

                <textarea
                    name="observaciones"
                    rows="4"
                    class="w-full rounded-xl border p-4"></textarea>

            </div>

        </div>

        {{-- Costo y evidencias --}}
        <div class="bg-white rounded-2xl shadow">

            <div class="border-b px-8 py-6">

                <h2 class="text-xl font-bold">

                    Información adicional

                </h2>

            </div>

            <div class="p-8 grid md:grid-cols-2 gap-8">

                <div>

                    <label class="font-semibold">

                        Costo

                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="costo"
                        value="0"
                        class="mt-2 w-full border rounded-xl p-3">

                </div>

                <div>

                    <label class="font-semibold">

                        Evidencias finales

                    </label>

                    <input
                        type="file"
                        multiple
                        name="evidencias[]"
                        class="mt-2">

                </div>

            </div>

        </div>

        {{-- Botón --}}
        <div class="flex justify-end">

            <button
                class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-semibold">

                Guardar reporte y enviar a validación

            </button>

        </div>

    </form>

</div>

@endsection
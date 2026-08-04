@extends('layouts.erp')

@section('content')

<div class="space-y-6">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Órdenes de Trabajo
            </h1>

            <p class="text-gray-500 mt-1">
                Administra todas las solicitudes de mantenimiento.
            </p>
        </div>

        <a href="{{ route('ordenes.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow transition">

            + Nueva Orden

        </a>

    </div>

    {{-- Tarjetas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-yellow-500">

            <p class="text-gray-500 text-sm">Pendientes</p>

            <h2 class="text-4xl font-bold mt-2">
                {{ $ordenes->where('estado','Pendiente')->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-500">

            <p class="text-gray-500 text-sm">En proceso</p>

            <h2 class="text-4xl font-bold mt-2">
                {{ $ordenes->where('estado','En proceso')->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">

            <p class="text-gray-500 text-sm">Finalizadas</p>

            <h2 class="text-4xl font-bold mt-2">
                {{ $ordenes->where('estado','Finalizada')->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-red-500">

            <p class="text-gray-500 text-sm">Canceladas</p>

            <h2 class="text-4xl font-bold mt-2">
                {{ $ordenes->where('estado','Cancelada')->count() }}
            </h2>

        </div>

    </div>

    {{-- Busqueda --}}
    <div class="bg-white rounded-2xl shadow p-5">

        <div class="grid md:grid-cols-5 gap-4">

            <input
                type="text"
                placeholder="Buscar folio..."
                class="border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200">

            <select class="border rounded-xl px-4 py-3">
                <option>Todas las sucursales</option>
            </select>

            <select class="border rounded-xl px-4 py-3">
                <option>Todos los estados</option>
            </select>

            <select class="border rounded-xl px-4 py-3">
                <option>Todas las prioridades</option>
            </select>

            <select class="border rounded-xl px-4 py-3">
                <option>Todas las categorías</option>
            </select>

        </div>

    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-100">

                <tr>

                    <th class="px-6 py-4 text-left">Folio</th>

                    <th class="px-6 py-4 text-left">Categoría</th>

                    <th class="px-6 py-4 text-left">Equipo / Servicio</th>

                    <th class="px-6 py-4 text-left">Sucursal</th>

                    <th class="px-6 py-4 text-left">Estado</th>

                    <th class="px-6 py-4 text-left">Prioridad</th>

                    <th class="px-6 py-4 text-left">Técnico</th>

                    <th class="px-6 py-4 text-left">Fecha</th>

                    <th class="px-6 py-4 text-center">Acciones</th>

                </tr>

                </thead>

                <tbody>

                @forelse($ordenes as $orden)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-6 py-4 font-semibold">
                            {{ $orden->folio }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $orden->categoria }}
                        </td>

                        <td class="px-6 py-4">

                            @if($orden->categoria=='Equipo')

                                {{ optional($orden->equipo)->nombre }}

                            @else

                                {{ optional($orden->servicio)->nombre }}

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            {{ optional($orden->sucursal)->name }}

                        </td>

                        <td class="px-6 py-4">

                            @switch($orden->estado)

                                @case('Pendiente')

                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs">
                                        Pendiente
                                    </span>

                                @break

                                @case('En proceso')

                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                                        En proceso
                                    </span>

                                @break

                                @case('Finalizada')

                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs">
                                        Finalizada
                                    </span>

                                @break

                                @default

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                        Cancelada
                                    </span>

                            @endswitch

                        </td>

                        <td class="px-6 py-4">

                            @switch($orden->prioridad)

                                @case('Baja')

                                    <span class="text-green-600 font-semibold">
                                        Baja
                                    </span>

                                @break

                                @case('Media')

                                    <span class="text-yellow-600 font-semibold">
                                        Media
                                    </span>

                                @break

                                @case('Alta')

                                    <span class="text-orange-600 font-semibold">
                                        Alta
                                    </span>

                                @break

                                @default

                                    <span class="text-red-600 font-semibold">
                                        Crítica
                                    </span>

                            @endswitch

                        </td>
                        
                        <td class="px-6 py-4">

                            {{ optional($orden->tecnico)->name ?? 'Sin asignar' }}

                        </td>

                        <td class="px-6 py-4">

                            {{ $orden->created_at->format('d/m/Y') }}

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                               <a href="{{ route('ordenes.show', $orden) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition"
                                title="Abrir orden">

                                    👁️

                                </a>

                                <a href="{{ route('ordenes.edit',$orden) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg">

                                    ✏

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9">

                            <div class="text-center py-20">

                                <div class="text-6xl mb-4">
                                    📋
                                </div>

                                <h2 class="text-xl font-semibold text-gray-700">

                                    No existen órdenes de trabajo

                                </h2>

                                <p class="text-gray-500 mt-2">

                                    Crea la primera orden para comenzar.

                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div>

        {{ $ordenes->links() }}

    </div>

</div>

@endsection
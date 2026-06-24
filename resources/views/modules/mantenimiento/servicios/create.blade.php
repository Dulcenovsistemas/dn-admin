@extends('layouts.erp')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-semibold mb-2">
        Nuevo Servicio
    </h1>

    <p class="text-gray-500 mb-6">
        {{ $sucursal->name }} / {{ $area->name }}
    </p>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('servicios.store') }}" method="POST">

            @csrf

            <input type="hidden"
                   name="sucursal_id"
                   value="{{ $sucursal->id }}">

            <input type="hidden"
                   name="area_id"
                   value="{{ $area->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Tipo de servicio
                    </label>

                    <select name="tipo_servicio"
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Seleccionar...</option>
                        <option value="Internet">Internet</option>
                        <option value="Camaras">Camaras</option>
                        <option value="Electricidad">Electricidad</option>
                        <option value="Gas LP">Gas LP</option>
                        <option value="Baños">Baños</option>
                        <option value="Agua">Agua</option>
                        <option value="Drenaje">Drenaje</option>
                        <option value="Seguridad">Seguridad</option>
                        <option value="Pared">Pared</option>
                        <option value="Techo">Techo</option>
                        <option value="Piso">Piso</option>
                        <option value="Movilidad">Movilidad</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Nombre
                    </label>

                    <input type="text"
                           name="nombre"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Proveedor
                    </label>

                    <input type="text"
                           name="proveedor"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Número de contrato
                    </label>

                    <input type="text"
                           name="numero_contrato"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Costo mensual
                    </label>

                    <input type="number"
                           step="0.01"
                           name="costo_mensual"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Fecha de inicio
                    </label>

                    <input type="date"
                           name="fecha_inicio"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Estatus
                    </label>

                    <select name="estatus"
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="Activo">Activo</option>
                        <option value="Suspendido">Suspendido</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>

            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium mb-1">
                    Descripción
                </label>

                <textarea name="descripcion"
                          rows="4"
                          class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('servicios.area', $area->id) }}"
                   class="px-4 py-2 border rounded-lg">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Guardar servicio
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
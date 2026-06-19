@extends('layouts.erp')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-semibold mb-6">
        Editar Servicio
    </h1>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('servicios.update', $servicio->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label>Tipo de servicio</label>

                    <input type="text"
                           name="tipo_servicio"
                           value="{{ old('tipo_servicio', $servicio->tipo_servicio) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label>Nombre</label>

                    <input type="text"
                           name="nombre"
                           value="{{ old('nombre', $servicio->nombre) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label>Proveedor</label>

                    <input type="text"
                           name="proveedor"
                           value="{{ old('proveedor', $servicio->proveedor) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label>Contrato</label>

                    <input type="text"
                           name="numero_contrato"
                           value="{{ old('numero_contrato', $servicio->numero_contrato) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label>Costo mensual</label>

                    <input type="number"
                           step="0.01"
                           name="costo_mensual"
                           value="{{ old('costo_mensual', $servicio->costo_mensual) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label>Fecha inicio</label>

                    <input type="date"
                           name="fecha_inicio"
                           value="{{ old('fecha_inicio', $servicio->fecha_inicio) }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

            </div>

            <div class="mt-4">

                <label>Descripción</label>

                <textarea name="descripcion"
                          rows="4"
                          class="w-full border rounded-lg px-3 py-2">{{ old('descripcion', $servicio->descripcion) }}</textarea>

            </div>

            <div class="mt-6">

                <label>Estatus</label>

                <select name="estatus"
                        class="w-full border rounded-lg px-3 py-2">

                    <option value="Activo"
                        {{ $servicio->estatus == 'Activo' ? 'selected' : '' }}>
                        Activo
                    </option>

                    <option value="Suspendido"
                        {{ $servicio->estatus == 'Suspendido' ? 'selected' : '' }}>
                        Suspendido
                    </option>

                    <option value="Cancelado"
                        {{ $servicio->estatus == 'Cancelado' ? 'selected' : '' }}>
                        Cancelado
                    </option>

                </select>

            </div>

            <div class="mt-6 flex justify-end gap-3">

                <a href="{{ route('servicios.show', $servicio->id) }}"
                   class="px-4 py-2 border rounded-lg">
                    Cancelar
                </a>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
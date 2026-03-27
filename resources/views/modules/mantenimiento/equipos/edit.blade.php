@extends('layouts.erp')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">
            Editar equipo
        </h1>
        <p class="text-sm text-gray-500">
            Modifica la información del equipo
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <form method="POST" action="{{ route('equipos.update', $equipo->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- SUCURSAL --}}
            <div>
                <label class="text-sm text-gray-600 mb-1 block">Sucursal</label>
                <select name="sucursal_id" id="sucursal" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}"
                            {{ $equipo->sucursal_id == $sucursal->id ? 'selected' : '' }}>
                            {{ $sucursal->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- AREA --}}
            <div>
                <label class="text-sm text-gray-600 mb-1 block">Área</label>
                <select name="area_id" id="area" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}"
                            data-sucursal="{{ $area->branch_id }}"
                            {{ $equipo->area_id == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NOMBRE --}}
            <div>
                <label class="text-sm text-gray-600 mb-1 block">Nombre</label>
                <input type="text" name="nombre" value="{{ $equipo->nombre }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- MARCA --}}
            <div>
                <label class="text-sm text-gray-600 mb-1 block">Marca / Modelo</label>
                <input type="text" name="marca_modelo" value="{{ $equipo->marca_modelo }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- SERIE --}}
            <div>
                <label class="text-sm text-gray-600 mb-1 block">Número de serie</label>
                <input type="text" name="numero_serie" value="{{ $equipo->numero_serie }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- FECHA --}}
            <div>
                <label class="text-sm text-gray-600 mb-1 block">Fecha adquisición</label>
                <input type="date" name="fecha_adquisicion" value="{{ $equipo->fecha_adquisicion }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- RESPONSABLE --}}
            <div class="md:col-span-2">
                <label class="text-sm text-gray-600 mb-1 block">Responsable</label>
                <input type="text" name="responsable" value="{{ $equipo->responsable }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

        </div>

        {{-- ESPECIFICACIONES --}}
        <div class="mt-6">
            <label class="text-sm text-gray-600 mb-1 block">Especificaciones</label>
            <textarea name="especificaciones"
                rows="6"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            {{ old('especificaciones', isset($equipo) ? $equipo->especificaciones : "Voltaje:\nCapacidad:\nConsumo:\nMarca:\nModelo:\nObservaciones:") }}
            </textarea>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('equipos.show', $equipo->id) }}"
               class="text-gray-600 hover:text-black">
                Cancelar
            </a>

            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                Actualizar equipo
            </button>
        </div>

        </form>

    </div>

</div>

{{-- SCRIPT (igual que create) --}}
<script>
document.addEventListener("DOMContentLoaded", function(){

    const sucursalSelect = document.getElementById("sucursal");
    const areaOptions = document.querySelectorAll("#area option");

    function filtrarAreas() {
        const sucursalId = sucursalSelect.value;

        areaOptions.forEach(function(option){
            if(option.dataset.sucursal === sucursalId){
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
    }

    sucursalSelect.addEventListener("change", filtrarAreas);

    // 🔥 IMPORTANTE: ejecutar al cargar (para edit)
    filtrarAreas();
});
</script>

@endsection
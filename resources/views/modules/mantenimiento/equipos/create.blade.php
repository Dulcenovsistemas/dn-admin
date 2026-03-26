@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Crear Equipo
</h1>

<form method="POST" action="{{ route('equipos.store') }}">
@csrf

<div class="grid grid-cols-2 gap-6">

    {{-- SUCURSAL --}}
    <div>
        <label class="block text-sm font-medium">Sucursal</label>
        <select name="sucursal_id" id="sucursal"
                class="w-full border rounded p-2">
            <option value="">Seleccionar</option>
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}">
                    {{ $sucursal->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- AREA --}}
    <div>
        <label class="block text-sm font-medium">Área</label>
        <select name="area_id" id="area"
                class="w-full border rounded p-2">
            <option value="">Seleccionar</option>

            @foreach($areas as $area)
                <option value="{{ $area->id }}"
                        data-sucursal="{{ $area->branch_id }}"
                        style="display:none">
                    {{ $area->name }}
                </option>
            @endforeach

        </select>
    </div>

    {{-- NOMBRE --}}
    <div>
        <label class="block text-sm font-medium">Nombre</label>
        <input type="text" name="nombre"
               class="w-full border rounded p-2">
    </div>

    {{-- MARCA --}}
    <div>
        <label class="block text-sm font-medium">Marca / Modelo</label>
        <input type="text" name="marca_modelo"
               class="w-full border rounded p-2">
    </div>

    {{-- SERIE --}}
    <div>
        <label class="block text-sm font-medium">Número de serie</label>
        <input type="text" name="numero_serie"
               class="w-full border rounded p-2">
    </div>

    {{-- FECHA --}}
    <div>
        <label class="block text-sm font-medium">Fecha adquisición</label>
        <input type="date" name="fecha_adquisicion"
               class="w-full border rounded p-2">
    </div>

    {{-- RESPONSABLE --}}
    <div>
        <label class="block text-sm font-medium">Responsable</label>
        <input type="text" name="responsable"
               class="w-full border rounded p-2">
    </div>

</div>

{{-- ESPECIFICACIONES --}}
<div class="mt-6">
    <label class="block text-sm font-medium">Especificaciones</label>
    <textarea name="especificaciones"
              class="w-full border rounded p-2"
              rows="4"></textarea>
</div>

<button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">
    Guardar equipo
</button>

</form>

{{-- 🔥 SCRIPT --}}
<script>

document.addEventListener("DOMContentLoaded", function(){

    const sucursalSelect = document.getElementById("sucursal");
    const areaOptions = document.querySelectorAll("#area option");

    sucursalSelect.addEventListener("change", function(){

        const sucursalId = this.value;

        areaOptions.forEach(function(option){

            if(option.value === "") return;

            if(option.dataset.sucursal === sucursalId){
                option.style.display = "block";
            } else {
                option.style.display = "none";
                option.selected = false;
            }

        });

    });

});

</script>

@endsection
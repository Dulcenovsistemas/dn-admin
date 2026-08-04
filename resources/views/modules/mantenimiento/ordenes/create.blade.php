@extends('layouts.erp')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Nueva Orden de Trabajo
            </h1>

            <p class="text-gray-500">
                Registra una nueva solicitud de mantenimiento.
            </p>

        </div>

        <a href="{{ route('ordenes.index') }}"
            class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl">

            Volver

        </a>

    </div>

    <form action="{{ route('ordenes.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="bg-white rounded-2xl shadow p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Sucursal --}}
                <div>

                    <label class="font-semibold text-gray-700">
                        Sucursal
                    </label>

                    <select
                        name="branch_id"
                        class="w-full mt-2 border rounded-xl p-3">

                        <option value="">Seleccione...</option>

                        @foreach($sucursales as $sucursal)

                            <option value="{{ $sucursal->id }}">

                                {{ $sucursal->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Área --}}
                <div>

                    <label class="font-semibold">

                        Área

                    </label>

                    <select
                        id="area_id"
                        name="area_id"
                        class="w-full mt-2 border rounded-xl p-3">

                        <option value="">Seleccione un área...</option>

                    </select>

                </div>

                {{-- Solicitante --}}
                <div>

                    <label class="font-semibold">
                        Solicitante
                    </label>

                    <input
                        type="text"
                        class="w-full mt-2 border rounded-xl p-3 bg-gray-100"
                        value="{{ auth()->user()->name }}"
                        readonly>

                </div>

                {{-- Categoria --}}
                <div>

                    <label class="font-semibold">

                        Categoría

                    </label>

                    <select
                        id="categoria"
                        name="categoria"
                        class="w-full mt-2 border rounded-xl p-3">

                        <option value="">Seleccione...</option>

                        <option value="Equipo">

                            Equipo

                        </option>

                        <option value="Servicio">

                            Servicio

                        </option>

                    </select>

                </div>

                {{-- Equipo --}}
                <div id="equipoDiv" class="hidden">

                    <label class="font-semibold">

                        Equipo

                    </label>

                    <select
                        id="equipo_id"
                        name="equipo_id"
                        class="w-full mt-2 border rounded-xl p-3">

                        <option value="">Seleccione un equipo...</option>

                    </select>

                </div>

                {{-- Servicio --}}
                <div id="servicioDiv" class="hidden">

                    <label class="font-semibold">

                        Servicio

                    </label>

                   <select
                        id="servicio_id"
                        name="servicio_id"
                        class="w-full mt-2 border rounded-xl p-3">

                        <option value="">Seleccione un servicio...</option>

                    </select>

                </div>

                {{-- Tipo --}}
                <div>

                    <label class="font-semibold">

                        Tipo de mantenimiento

                    </label>

                    <select
                        name="tipo_mantenimiento"
                        class="w-full mt-2 border rounded-xl p-3">

                        <option>Correctivo</option>
                        <option>Preventivo</option>
                        <option>Instalación</option>
                        <option>Revisión</option>
                        <option>Emergencia</option>

                    </select>

                </div>

                {{-- Prioridad --}}
                <div>

                    <label class="font-semibold">

                        Prioridad

                    </label>

                    <select
                        name="prioridad"
                        class="w-full mt-2 border rounded-xl p-3">

                        <option>Baja</option>
                        <option selected>Media</option>
                        <option>Alta</option>


                    </select>

                </div>

                


            </div>

            {{-- Descripcion --}}

            <div class="mt-8">

                <label class="font-semibold">

                    Descripción

                </label>

                <textarea
                    name="descripcion"
                    rows="5"
                    class="w-full mt-2 border rounded-xl p-3"></textarea>

            </div>

            {{-- Evidencias --}}

            <div class="mt-8">

                <label class="font-semibold">

                    Evidencias

                </label>

                <input
                    type="file"
                    name="evidencias[]"
                    multiple
                    class="mt-2">

            </div>

            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('ordenes.index') }}"
                    class="bg-gray-300 px-5 py-3 rounded-xl">

                    Cancelar

                </a>

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                    Guardar Orden

                </button>

            </div>

        </div>

    </form>

</div>

<script>

const sucursal = document.querySelector('[name="branch_id"]');
const area = document.getElementById('area_id');
const categoria = document.getElementById('categoria');

const equipoDiv = document.getElementById('equipoDiv');
const servicioDiv = document.getElementById('servicioDiv');

const equipo = document.getElementById('equipo_id');
const servicio = document.getElementById('servicio_id');


sucursal.addEventListener('change', function(){

    area.innerHTML = '<option>Cargando...</option>';

    fetch('/areas/' + this.value)

    .then(res => res.json())

    .then(data=>{

        area.innerHTML = '<option value="">Seleccione un área...</option>';

        data.forEach(item=>{

            area.innerHTML += `
                <option value="${item.id}">
                    ${item.name}
                </option>
            `;

        });

    });

});


function cargarDatos(){

    if(area.value=='' || categoria.value=='')
        return;

    fetch(`/equipos-servicios?area_id=${area.value}&categoria=${categoria.value}`)

    .then(res=>res.json())

    .then(data=>{

        if(categoria.value=='Equipo'){

            equipoDiv.classList.remove('hidden');
            servicioDiv.classList.add('hidden');

            equipo.innerHTML='';

            data.forEach(item=>{

                equipo.innerHTML+=`
                    <option value="${item.id}">
                        ${item.nombre}
                    </option>
                `;

            });

        }else{

            servicioDiv.classList.remove('hidden');
            equipoDiv.classList.add('hidden');

            servicio.innerHTML='';

            data.forEach(item=>{

                servicio.innerHTML+=`
                    <option value="${item.id}">
                        ${item.nombre}
                    </option>
                `;

            });

        }

    });

}

categoria.addEventListener('change',cargarDatos);

area.addEventListener('change',cargarDatos);

</script>

@endsection
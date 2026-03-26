@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Editar Sucursal
</h1>

<form method="POST" action="{{ route('sucursales.update', $branch->id) }}">
    @csrf
    @method('PUT')

    <div class="bg-white p-6 rounded-xl shadow mb-6">

        <label class="block text-sm font-medium mb-2">
            Nombre
        </label>

        <input type="text" name="name"
               value="{{ $branch->name }}"
               class="w-full border rounded p-2 mb-4">

    </div>

    {{-- 🔥 AREAS --}}
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-semibold mb-4">
            Áreas
        </h2>

        <div id="areas-container">

            @foreach($branch->areas as $area)
                <div class="flex gap-2 mb-2">
                    <input type="text"
                           name="areas_existing[{{ $area->id }}]"
                           value="{{ $area->name }}"
                           class="w-full border rounded p-2">

                    <button type="button" onclick="this.parentElement.remove()">
                        ❌
                    </button>
                </div>
            @endforeach

        </div>

        <button type="button" onclick="addArea()"
                class="mt-2 text-blue-600">
            + Agregar área
        </button>

    </div>

    <h2 class="text-lg font-semibold mt-8 mb-4">
        Puestos de la sucursal
        </h2>

        <div class="grid grid-cols-3 gap-4">

        @foreach($jobPositions as $job)

            <label class="border rounded p-3 block">
                <input type="checkbox"
                    name="job_positions[]"
                    value="{{ $job->id }}"
                    {{ in_array($job->id, $branchJobs) ? 'checked' : '' }}>

                {{ $job->name }}
            </label>

        @endforeach

        </div>

    <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">
        Guardar cambios
    </button>

</form>

<script>
function addArea(){
    const container = document.getElementById('areas-container');

    const html = `
        <div class="flex gap-2 mb-2">
            <input type="text" name="areas_new[]" class="w-full border rounded p-2" placeholder="Nueva área">
            <button type="button" onclick="this.parentElement.remove()">❌</button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
}
</script>

@endsection
@extends('layouts.erp')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- 🧠 Título --}}
    <h1 class="text-2xl font-semibold mb-1">Crear ingrediente</h1>
    <p class="text-gray-500 mb-6">Registra un nuevo ingrediente en el sistema</p>

    {{-- 🧱 CARD --}}
    <div class="bg-white rounded-2xl shadow-md p-6">

        <form method="POST" action="{{ route('ingredientes.store') }}">
            @csrf

            {{-- 🔥 GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Nombre --}}
                <div>
                    <label class="text-sm text-gray-600">Nombre</label>
                    <input type="text" name="name"
                        class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>
                </div>

                {{-- Unidad --}}
                <div>
                    <label class="text-sm text-gray-600">Unidad</label>
                    <select name="unit"
                        class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>

                        <option value="">Seleccionar</option>
                        <option value="KG">KG</option>
                        <option value="PZ">PZ</option>
                        <option value="LT">LT</option>

                    </select>
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="text-sm text-gray-600">Categoría</label>
                    <select name="categoria_id" id="categoria"
                        class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>
                        <option value="">Seleccionar</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                data-name="{{ strtolower($cat->nombre) }}">
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategoría --}}
                <div>
                    <label class="text-sm text-gray-600">Subcategoría</label>
                    <select name="subcategoria_id" id="subcategoria"
                        class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>
                        <option value="">Seleccionar</option>
       
                    </select>
                </div>

                {{-- Costo normal --}}
                <div>
                    <label class="text-sm text-gray-600">Costo por unidad</label>
                    <input type="number" step="0.01" name="cost_per_unit"
                        class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                        required>
                </div>

            </div>

            {{-- 🧃 CAMPOS BATIDO --}}
            <div id="batido-fields" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm text-gray-600">Costo por cubeta</label>
                    <input type="number" step="0.01" name="cost_per_bucket"
                        id="cost_per_bucket"
                        class="w-full mt-1 border rounded-lg p-2">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Costo por litro</label>
                    <input type="number" step="0.01" name="cost_per_liter"
                        id="cost_per_liter"
                        class="w-full mt-1 border rounded-lg p-2">
                </div>

            </div>

            {{-- 🚀 BOTONES --}}
            <div class="flex justify-end gap-3 mt-6">

                <a href="{{ route('ingredientes.index') }}"
                   class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                    Cancelar
                </a>

                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">
                    Guardar ingrediente
                </button>

            </div>

        </form>

    </div>

</div>

{{-- 🔥 SCRIPT --}}
<script>
    const categoriaSelect = document.getElementById('categoria');
    const subcategoriaSelect = document.getElementById('subcategoria');
    const batidoFields = document.getElementById('batido-fields');

    const bucket = document.getElementById('cost_per_bucket');
    const liter = document.getElementById('cost_per_liter');

    const subcategorias = @json($subcategorias);

    function cargarSubcategorias(categoriaId) {
        subcategoriaSelect.innerHTML = '<option value="">Seleccionar</option>';

        subcategorias.forEach(sub => {
            if (sub.categoria_id == categoriaId) {
                subcategoriaSelect.innerHTML += `
                    <option value="${sub.id}">${sub.nombre}</option>
                `;
            }
        });
    }

    function toggleBatidoFields() {
        const selected = categoriaSelect.options[categoriaSelect.selectedIndex];
        const name = selected.getAttribute('data-name');

        if (name && name.includes('batido')) {
            batidoFields.classList.remove('hidden');
            bucket.required = true;
            liter.required = true;
        } else {
            batidoFields.classList.add('hidden');
            bucket.required = false;
            liter.required = false;
            bucket.value = '';
            liter.value = '';
        }
    }

    categoriaSelect.addEventListener('change', function () {
        cargarSubcategorias(this.value);
        toggleBatidoFields();
    });
</script>

@endsection
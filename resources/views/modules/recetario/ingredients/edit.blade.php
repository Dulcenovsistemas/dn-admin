@extends('layouts.erp')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- 🧠 Título --}}
    <h1 class="text-2xl font-semibold mb-1">Crear ingrediente</h1>
    <p class="text-gray-500 mb-6">Registra un nuevo ingrediente en el sistema</p>

    {{-- 🧱 CARD --}}
    <div class="bg-white rounded-2xl shadow-md p-6">

        <form method="POST" action="{{ route('ingredientes.update', $ingredient->id) }}">
    @csrf
    @method('PUT')

            {{-- 🔥 GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Nombre --}}
                <div>
                    <label class="text-sm text-gray-600">Nombre</label>
                    <input type="text" name="name" value="{{ $ingredient->name }}"
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
                        <option value="KG" {{ $ingredient->unit == 'KG' ? 'selected' : '' }}>KG</option>
                        <option value="PZ" {{ $ingredient->unit == 'PZ' ? 'selected' : '' }}>PZ</option>
                        <option value="LT" {{ $ingredient->unit == 'LT' ? 'selected' : '' }}>LT</option>

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
                                {{ $ingredient->categoria_id == $cat->id ? 'selected' : '' }}>
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
                        value="{{ $ingredient->cost_per_unit }}"
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
                        value="{{ $ingredient->cost_per_bucket }}"
                        class="w-full mt-1 border rounded-lg p-2">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Costo por litro</label>
                    <input type="number" step="0.01" name="cost_per_liter"
                        id="cost_per_liter"
                        value="{{ $ingredient->cost_per_liter }}"
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
    const batidoCategoriaId = "{{ $batidoCategoriaId }}";

    const selectedCategoria = "{{ $ingredient->categoria_id ?? '' }}";
    const selectedSubcategoria = "{{ $ingredient->subcategoria_id ?? '' }}";

    function cargarSubcategorias(categoriaId, selectedId = null) {
        subcategoriaSelect.innerHTML = '<option value="">Seleccionar</option>';

        subcategorias.forEach(sub => {
            if (sub.categoria_id == categoriaId) {
                const selected = selectedId == sub.id ? 'selected' : '';
                subcategoriaSelect.innerHTML += `
                    <option value="${sub.id}" ${selected}>
                        ${sub.nombre}
                    </option>
                `;
            }
        });
    }

    function toggleBatidoFields() {
        if (categoriaSelect.value == batidoCategoriaId) {
            batidoFields.classList.remove('hidden');
            bucket.required = true;
            liter.required = true;
        } else {
            batidoFields.classList.add('hidden');
            bucket.required = false;
            liter.required = false;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (selectedCategoria) {
            cargarSubcategorias(selectedCategoria, selectedSubcategoria);
        }

        toggleBatidoFields();
    });

    categoriaSelect.addEventListener('change', function () {
        cargarSubcategorias(this.value);
        toggleBatidoFields();
    });
</script>

@endsection
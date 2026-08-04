<div class="bg-white rounded-2xl shadow">

    {{-- Encabezado --}}
    <div class="border-b px-8 py-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Información General
        </h2>

        <p class="text-gray-500 mt-1">
            Información básica de la orden de trabajo.
        </p>

    </div>

    <div class="p-8">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Sucursal --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Sucursal
                </label>

                <select
                    id="branch_id"
                    name="branch_id"
                    class="w-full mt-2 border rounded-xl p-3">

                    <option value="">Seleccione...</option>

                    @foreach($sucursales as $sucursal)

                        <option
                            value="{{ $sucursal->id }}"
                            @selected(old('branch_id', $ordene->branch_id ?? '') == $sucursal->id)>

                            {{ $sucursal->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Área --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Área
                </label>

                <select
                    id="area_id"
                    name="area_id"
                    class="w-full mt-2 border rounded-xl p-3">

                    <option value="">Seleccione un área...</option>

                    @isset($areas)

                        @foreach($areas as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(old('area_id', $ordene->area_id ?? '') == $item->id)>

                                {{ $item->name }}

                            </option>

                        @endforeach

                    @endisset

                </select>

            </div>

            {{-- Solicitante --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Solicitante
                </label>

                <input
                    type="text"
                    readonly
                    value="{{ old('solicitante', isset($ordene) ? $ordene->solicitante->name : auth()->user()->name) }}"
                    class="w-full mt-2 border rounded-xl p-3 bg-gray-100">

            </div>

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">

                    Prioridad

                </label>

                <select
                    name="prioridad"
                    class="w-full mt-2 border rounded-xl p-3">

                    <option
                        value="Baja"
                        @selected(old('prioridad', $ordene->prioridad ?? 'Media') == 'Baja')>

                        Baja

                    </option>

                    <option
                        value="Media"
                        @selected(old('prioridad', $ordene->prioridad ?? 'Media') == 'Media')>

                        Media

                    </option>

                    <option
                        value="Alta"
                        @selected(old('prioridad', $ordene->prioridad ?? 'Media') == 'Alta')>

                        Alta

                    </option>

                    <option
                        value="Crítica"
                        @selected(old('prioridad', $ordene->prioridad ?? 'Media') == 'Crítica')>

                        Crítica

                    </option>

                </select>

            </div>

        </div>

    </div>

</div>
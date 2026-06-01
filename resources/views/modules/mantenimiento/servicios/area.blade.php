@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-2">
    {{ $area?->name ?? 'Servicios' }}
</h1>

<p class="text-gray-500 mb-6">
    {{ $area?->sucursal?->name ?? 'Sin sucursal' }}
</p>

<div class="mb-6 flex justify-between items-center">

    <a href="{{ route('servicios.sucursal', $area->branch_id) }}"
       class="text-blue-600 hover:underline text-sm">
        ← Volver a áreas
    </a>

    @if(auth()->user()->hasModulePermission('servicios', 'create'))
        <a href="{{ route('servicios.create', ['area' => $area->id]) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Crear servicio
        </a>
    @endif

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-100 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-4 py-3 text-left">ID</th>
                <th class="px-4 py-3 text-left">Tipo</th>
                <th class="px-4 py-3 text-left">Servicio</th>
                <th class="px-4 py-3 text-left">Proveedor</th>
                <th class="px-4 py-3 text-left">Estatus</th>
                <th class="px-4 py-3 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($area->servicios as $servicio)
            <tr class="hover:bg-gray-50 transition">

                <td class="px-4 py-3 text-gray-400">
                    {{ $servicio->id }}
                </td>

                <td class="px-4 py-3 font-medium text-gray-800">
                    {{ $servicio->tipo_servicio }}
                </td>

                <td class="px-4 py-3 text-gray-600">
                    {{ $servicio->nombre }}
                </td>

                <td class="px-4 py-3 text-gray-500">
                    {{ $servicio->proveedor ?? '-' }}
                </td>

                <td class="px-4 py-3 text-gray-500">
                    {{ $servicio->estatus }}
                </td>

                <td class="px-4 py-3 text-right">

                    <div class="flex justify-end gap-2 text-xs">

                        <a href="{{ route('servicios.show', $servicio->id) }}"
                           class="text-blue-600 hover:text-blue-800">
                            Ver
                        </a>

                        @if(auth()->user()->hasModulePermission('servicios', 'edit'))
                            <a href="{{ route('servicios.edit', $servicio->id) }}"
                               class="text-gray-600 hover:text-black">
                                Editar
                            </a>
                        @endif

                        @if(auth()->user()->hasModulePermission('servicios', 'delete'))
                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('¿Eliminar este servicio?')"
                                        class="text-red-500 hover:text-red-700">
                                    Eliminar
                                </button>
                            </form>
                        @endif

                    </div>

                </td>

            </tr>
            @empty

            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                    No hay servicios registrados
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>
@endsection
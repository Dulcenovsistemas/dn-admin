@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-2">
    {{ $area->name }}
</h1>

<p class="text-gray-500 mb-6">
    {{ $area->sucursal->name }}
</p>

<div class="mb-6 flex justify-between items-center">

    <a href="{{ route('equipos.sucursal', $area->branch_id) }}" 
       class="text-blue-600 hover:underline text-sm">
        ← Volver a áreas
    </a>

    <a href="{{ route('equipos.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Crear equipo
    </a>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full text-sm">

        <thead class="bg-gray-100 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-4 py-3 text-left">ID</th>
                <th class="px-4 py-3 text-left">Equipo</th>
                <th class="px-4 py-3 text-left">Marca / Modelo</th>
                <th class="px-4 py-3 text-left">Serie</th>
                <th class="px-4 py-3 text-left">Responsable</th>
                <th class="px-4 py-3 text-right">Acciones</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($area->equipos as $equipo)
            <tr class="hover:bg-gray-50 transition">

                <td class="px-4 py-3 text-gray-400">
                    {{ $equipo->id }}
                </td>

                <td class="px-4 py-3 font-medium text-gray-800">
                    {{ $equipo->nombre }}
                </td>

                <td class="px-4 py-3 text-gray-600">
                    {{ $equipo->marca_modelo }}
                </td>

                <td class="px-4 py-3 text-gray-500">
                    {{ $equipo->numero_serie ?? '-' }}
                </td>

                <td class="px-4 py-3 text-gray-500">
                    {{ $equipo->responsable ?? '-' }}
                </td>

                <td class="px-4 py-3 text-right">

                    <div class="flex justify-end gap-2 text-xs">

                        <a href="{{ route('equipos.show', $equipo->id) }}"
                           class="text-blue-600 hover:text-blue-800">
                            Ver
                        </a>

                        <a href="{{ route('equipos.edit', $equipo->id) }}"
                           class="text-gray-600 hover:text-black">
                            Editar
                        </a>

                        <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('¿Eliminar este equipo?')"
                                    class="text-red-500 hover:text-red-700">
                                Eliminar
                            </button>
                        </form>

                    </div>

                </td>

            </tr>
            @empty

            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                    No hay equipos registrados
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>
@endsection
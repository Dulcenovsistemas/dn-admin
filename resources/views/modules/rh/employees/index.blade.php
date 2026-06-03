@extends('layouts.erp')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-semibold">
        Empleados
    </h1>

    @if(auth()->user()->hasModulePermission('empleados', 'edit'))
        <a href="{{ route('employees.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Nuevo empleado
        </a>
    @endif

</div>


<!-- FILTROS -->
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <!-- Buscar empleado -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Buscar empleado
            </label>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nombre, apellido o número..."
                class="w-full border rounded-lg px-3 py-2"
            >
        </div>

        <!-- Sucursal -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Sucursal
            </label>
            <select name="branch_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">Todas</option>
                @foreach(($branches ?? []) as $branch)
                    <option value="{{ $branch->id }}"
                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Puesto -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Puesto
            </label>
            <select name="job_position_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">Todos</option>

                @foreach(($jobPositions ?? []) as $position)
                    <option value="{{ $position->id }}"
                        {{ request('job_position_id') == $position->id ? 'selected' : '' }}>
                        {{ $position->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Departamento -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Departamento
            </label>
            <select name="department" class="w-full border rounded-lg px-3 py-2">
                <option value="">Todos</option>
                @foreach(($departments ?? []) as $department)
                    <option value="{{ $department }}"
                        {{ request('department') == $department ? 'selected' : '' }}>
                        {{ $department }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Botones -->
        <div class="flex items-end gap-2">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Filtrar
            </button>

            <a href="{{ route('employees.index') }}"
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Limpiar
            </a>
        </div>

    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full text-sm">

    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="p-4 text-left">ID</th>
            <th class="p-4 text-left">Empleado</th>
            <th class="p-4 text-left">Sucursal</th>
            <th class="p-4 text-left">Puesto</th>
            <th class="p-4 text-left">Departamento</th>
            <th class="p-4 text-left">Ingreso</th>
            <th class="p-4 text-left">Estatus</th>
            <th class="p-4 text-right">Acciones</th>
        </tr>
    </thead>

    <tbody>

    @forelse($employees as $employee)

        <tr class="border-b hover:bg-gray-50 transition">

             <!-- NUMERO DE EMPLEADO -->
            <td class="p-4">
    {{ $employee->employee_number ?? '-' }}
            </td>

            <!-- 👤 EMPLEADO -->
            <td class="p-4">

                <div class="flex items-center gap-3">

                    <!-- FOTO -->
                    <div class="w-8 h-12 rounded-full overflow-hidden bg-gray-200">

                        @if($employee->photo)
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500 text-xs">
                                Sin foto
                            </div>
                        @endif

                    </div>

                    <!-- NOMBRE -->
                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $employee->name }}
                            {{ $employee->last_name }}
                            {{ $employee->second_last_name }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $employee->phone }}
                        </p>
                    </div>

                </div>

            </td>

            <!-- 🏢 SUCURSAL -->
            <td class="p-4">
                {{ $employee->branch->name ?? '-' }}
            </td>

            <!-- 💼 PUESTO -->
            <td class="p-4">
                {{ $employee->jobPosition->name ?? '-' }}
            </td>

            <!-- 🧩 DEPARTAMENTO -->
            <td class="p-4">
                {{ $employee->department ?? '-' }}
            </td>

            <!-- 📅 INGRESO -->
            <td class="p-4">
                {{ $employee->hire_date ?? '-' }}
            </td>

            <!-- 🟡 STATUS -->
            <td class="p-4">

                @if($employee->status === 'active')

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                        Activo
                    </span>

                @else

                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                        Inactivo
                    </span>

                @endif

            </td>

            <!-- ⚙️ ACCIONES -->
            <td class="p-4">

                <div class="flex justify-end gap-3">

                    <a href="{{ route('employees.show', $employee->id) }}"
                        class="text-slate-600 hover:underline">
                            Ver
                        </a>


                    
                    @if(auth()->user()->hasModulePermission('empleados', 'edit'))
                        <a href="{{ route('employees.edit', $employee->id) }}"
                        class="text-blue-600 hover:underline">
                            Editar
                        </a>
                    @endif

                    @if(auth()->user()->hasModulePermission('empleados', 'delete'))
                        <form action="{{ route('employees.destroy', $employee->id) }}"
                            method="POST"
                            onsubmit="return confirm('¿Eliminar empleado?')">

                            @csrf
                            @method('DELETE')

                            <button class="text-red-500 hover:underline">
                                Eliminar
                            </button>

                        </form>
                    @endif

                </div>

            </td>

        </tr>

    @empty

        <tr>
            <td colspan="6" class="p-6 text-center text-gray-400">
                No hay empleados registrados
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

</div>

@endsection
@extends('layouts.erp')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-start mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800 uppercase">
                {{ $employee->name }}
                {{ $employee->last_name }}
                {{ $employee->second_last_name }}
            </h1>

            <p class="text-slate-500 mt-1 uppercase">
                {{ $employee->branch->name ?? '-' }}
                /
                {{ $employee->jobPosition->name ?? '-' }}
                /
                {{ $employee->department ?? '-' }}
              
            </p>

        </div>

        <div class="flex gap-6 text-sm">

            <a href="{{ route('employees.edit', $employee->id) }}"
               class="text-slate-700 hover:text-blue-600 transition">

                Editar

            </a>

            <a href="/rh"
               class="text-slate-700 hover:text-blue-600 transition">

                Volver

            </a>

        </div>

    </div>

    <!-- GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PANEL IZQUIERDO -->
        <div class="lg:col-span-2">

            <div class="bg-white rounded-2xl border border-slate-200 p-8">

                <h2 class="text-sm uppercase tracking-wide text-slate-500 mb-8">
                    Información general
                </h2>

                <!-- GRID INFO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">

                    <!-- TEL -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            Teléfono
                        </p>

                        <p class="font-semibold text-slate-800 uppercase">
                            {{ $employee->phone ?? '-' }}
                        </p>
                    </div>

                    <!-- NACIMIENTO -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            Fecha nacimiento
                        </p>

                        <p class="font-semibold text-slate-800 uppercase">
                            {{ $employee->birth_date ?? '-' }}
                        </p>
                    </div>

                    <!-- CURP -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            CURP
                        </p>

                        <p class="font-semibold text-slate-800 uppercase">
                            {{ $employee->curp ?? '-' }}
                        </p>
                    </div>

                    <!-- RFC -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            RFC
                        </p>

                        <p class="font-semibold text-slate-800 uppercase">
                            {{ $employee->rfc ?? '-' }}
                        </p>
                    </div>

                    <!-- IMSS -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            IMSS
                        </p>

                        <p class="font-semibold text-slate-800 uppercase">
                            {{ $employee->imss ?? '-' }}
                        </p>
                    </div>

                    <!-- CLABE -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            CLABE
                        </p>

                        <p class="font-semibold text-slate-800 uppercase">
                            {{ $employee->clabe ?? '-' }}
                        </p>
                    </div>

                    <!-- FECHA INGRESO -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            Fecha ingreso
                        </p>

                        <p class="font-semibold text-slate-800 uppercase">
                            {{ $employee->hire_date ?? '-' }}
                        </p>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            Estatus
                        </p>

                        <p class="font-semibold uppercase
                            {{ $employee->status === 'active'
                                ? 'text-green-600'
                                : 'text-red-600' }}">

                            {{ $employee->status === 'active'
                                ? 'Activo'
                                : 'Inactivo' }}

                        </p>
                    </div>

                </div>

                <!-- DIRECCIÓN -->
                <div class="mt-10">

                    <p class="text-sm text-slate-400 mb-2">
                        Dirección
                    </p>

                    <div class="bg-slate-50 rounded-xl p-5 text-slate-700 uppercase">

                        {{ $employee->address ?? '-' }}

                    </div>

                </div>

                <!-- DOCUMENTOS -->
                <div class="mt-10">

                    <p class="text-sm text-slate-400 mb-4">
                        Documentos
                    </p>

                    <div class="space-y-3">

                        @forelse($employee->files as $file)

                            <a href="{{ asset('storage/' . $file->file_path) }}"
                               target="_blank"
                               class="flex items-center justify-between border border-slate-200 rounded-xl p-4 hover:bg-slate-50 transition">

                                <div>

                                    <p class="font-medium text-slate-700">
                                        {{ $file->file_name }}
                                    </p>

                                </div>

                                <span class="text-slate-400">
                                    →
                                </span>

                            </a>

                        @empty

                            <div class="text-slate-400">
                                No hay documentos
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

        <!-- PANEL DERECHO -->
        <div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6">

                <h2 class="text-sm uppercase tracking-wide text-slate-500 mb-5 text-center">
                    Empleado
                </h2>

                <!-- FOTO -->
                <div class="w-full aspect-square rounded-2xl overflow-hidden bg-slate-200">

                    @if($employee->photo)

                        <img src="{{ asset('storage/' . $employee->photo) }}"
                             class="w-full h-full object-cover">

                    @else

                        <div class="w-full h-full flex items-center justify-center text-slate-500">
                            Sin foto
                        </div>

                    @endif

                </div>

                <!-- INFO -->
                <div class="mt-6 text-center">

                    <h3 class="text-xl font-bold text-slate-800 uppercase">

                        {{ $employee->name }}
                        {{ $employee->last_name }}

                    </h3>

                    <p class="text-slate-500 mt-2 uppercase">
                        {{ $employee->jobPosition->name ?? '-' }}
                    </p>

                    <p class="text-sm text-slate-400 mt-1">
                        Nacimiento:
                        {{ $employee->birth_date ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
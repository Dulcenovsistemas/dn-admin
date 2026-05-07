@extends('layouts.erp')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800 uppercase">
                Editar empleado
            </h1>

            <p class="text-slate-500 mt-1">
                Actualiza la información del empleado
            </p>

        </div>

        <a href="{{ route('employees.show', $employee->id) }}"
           class="px-5 py-2 rounded-xl border border-slate-300 hover:bg-slate-50 transition">

            Volver

        </a>

    </div>

    <form method="POST"
          action="{{ route('employees.update', $employee->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- PANEL IZQUIERDO -->
            <div class="lg:col-span-8 space-y-6">

                <!-- DATOS PERSONALES -->
                <div class="bg-white rounded-2xl border border-slate-200 p-8">

                    <h2 class="text-sm uppercase tracking-wide text-slate-500 mb-8">
                        Datos personales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- NOMBRE -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Nombre
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $employee->name) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- APELLIDO -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Apellido paterno
                            </label>

                            <input type="text"
                                   name="last_name"
                                   value="{{ old('last_name', $employee->last_name) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- SEGUNDO APELLIDO -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Apellido materno
                            </label>

                            <input type="text"
                                   name="second_last_name"
                                   value="{{ old('second_last_name', $employee->second_last_name) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- TEL -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Teléfono
                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $employee->phone) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- NACIMIENTO -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Fecha nacimiento
                            </label>

                            <input type="date"
                                   name="birth_date"
                                   value="{{ old('birth_date', $employee->birth_date) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- DIRECCION -->
                        <div class="md:col-span-2">
                            <label class="block text-sm text-slate-500 mb-2">
                                Dirección
                            </label>

                            <textarea name="address"
                                      rows="3"
                                      class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">{{ old('address', $employee->address) }}</textarea>
                        </div>

                    </div>

                </div>

                <!-- DATOS LABORALES -->
                <div class="bg-white rounded-2xl border border-slate-200 p-8">

                    <h2 class="text-sm uppercase tracking-wide text-slate-500 mb-8">
                        Datos laborales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- SUCURSAL -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Sucursal
                            </label>

                            <select name="branch_id"
                                    id="branch_id"
                                    class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">

                                <option value="">
                                    Seleccionar
                                </option>

                                @foreach($branches as $branch)

                                    <option value="{{ $branch->id }}"
                                        {{ $employee->branch_id == $branch->id ? 'selected' : '' }}>

                                        {{ $branch->name }}

                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <!-- PUESTO -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Puesto
                            </label>

                            <select name="job_position_id"
                                    id="job_position_id"
                                    class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">

                                @if($employee->jobPosition)

                                    <option value="{{ $employee->jobPosition->id }}" selected>
                                        {{ $employee->jobPosition->name }}
                                    </option>

                                @else

                                    <option value="">
                                        Seleccionar
                                    </option>

                                @endif

                            </select>
                        </div>

                        <!-- DEPARTAMENTO -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Departamento
                            </label>

                            <input type="text"
                                   name="department"
                                   value="{{ old('department', $employee->department) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- FECHA INGRESO -->
                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                Fecha ingreso
                            </label>

                            <input type="date"
                                   name="hire_date"
                                   value="{{ old('hire_date', $employee->hire_date) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                    </div>

                </div>

                <!-- DATOS FISCALES -->
                <div class="bg-white rounded-2xl border border-slate-200 p-8">

                    <h2 class="text-sm uppercase tracking-wide text-slate-500 mb-8">
                        Datos fiscales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                CURP
                            </label>

                            <input type="text"
                                   name="curp"
                                   value="{{ old('curp', $employee->curp) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                RFC
                            </label>

                            <input type="text"
                                   name="rfc"
                                   value="{{ old('rfc', $employee->rfc) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                IMSS
                            </label>

                            <input type="text"
                                   name="imss"
                                   value="{{ old('imss', $employee->imss) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 uppercase focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm text-slate-500 mb-2">
                                CLABE
                            </label>

                            <input type="text"
                                   name="clabe"
                                   value="{{ old('clabe', $employee->clabe) }}"
                                   class="w-full border border-slate-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                    </div>

                </div>

            </div>

            <!-- PANEL DERECHO -->
            <div class="lg:col-span-4">

                <div class="bg-white rounded-2xl border border-slate-200 p-6 sticky top-6">

                    <h2 class="text-sm uppercase tracking-wide text-slate-500 mb-5 text-center">
                        Empleado
                    </h2>

                    <!-- FOTO -->
                    <div class="w-64 h-64 mx-auto rounded-2xl overflow-hidden bg-slate-200">

                        @if($employee->photo)

                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                 class="w-full h-full object-cover">

                        @else

                            <div class="w-full h-full flex items-center justify-center text-slate-500">
                                Sin foto
                            </div>

                        @endif

                    </div>

                    <!-- NUEVA FOTO -->
                    <div class="mt-6">

                        <label class="block text-sm text-slate-500 mb-2">
                            Cambiar foto
                        </label>

                        <input type="file"
                               name="photo"
                               class="w-full border border-slate-300 rounded-xl p-3">
                    </div>

                    <!-- ARCHIVOS -->
                    <div class="mt-6">

                        <label class="block text-sm text-slate-500 mb-2">
                            Agregar documentos
                        </label>

                        <input type="file"
                               name="files[]"
                               multiple
                               class="w-full border border-slate-300 rounded-xl p-3">
                    </div>

                    <!-- BOTONES -->
                    <div class="flex flex-col gap-3 mt-8">

                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 transition font-medium">
                            Guardar cambios
                        </button>

                        <a href="{{ route('employees.show', $employee->id) }}"
                           class="w-full border border-slate-300 rounded-xl py-3 text-center hover:bg-slate-50 transition">

                            Cancelar

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
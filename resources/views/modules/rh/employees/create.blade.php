@extends('layouts.erp')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Nuevo empleado
            </h1>

            <p class="text-slate-500 mt-1">
                Registro de información del empleado
            </p>
        </div>

        <a href="/rh"
           class="inline-flex items-center gap-2 border border-slate-300 bg-white px-5 py-3 rounded-xl hover:bg-slate-50 transition shadow-sm text-slate-700">
            ← Volver
        </a>

    </div>

    <form method="POST"
          action="{{ route('employees.store') }}"
          enctype="multipart/form-data">

    @csrf

    <div class="space-y-8">

        <!-- 🔵 DATOS PERSONALES -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">

            <div class="flex items-center gap-3 mb-6">

                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center text-xl">
                    👤
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-800">
                        Datos personales
                    </h2>

                    <p class="text-sm text-slate-500">
                        Información general del empleado
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- NOMBRE -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Nombre
                    </label>

                    <input name="name"
                           class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- APELLIDO PATERNO -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Apellido paterno
                    </label>

                    <input name="last_name"
                           class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- APELLIDO MATERNO -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Apellido materno
                    </label>

                    <input name="second_last_name"
                           class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- FECHA NACIMIENTO -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Fecha de nacimiento
                    </label>

                    <input type="date"
                           name="birth_date"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Teléfono
                    </label>

                    <input name="phone"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- DIRECCIÓN -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Dirección
                    </label>

                    <input name="address"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

            </div>

        </div>

        <!-- 🟢 DATOS LABORALES -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">

            <div class="flex items-center gap-3 mb-6">

                <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl">
                    💼
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-800">
                        Datos laborales
                    </h2>

                    <p class="text-sm text-slate-500">
                        Información interna de la empresa
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- SUCURSAL -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Sucursal
                    </label>

                    <select name="branch_id"
                            id="branch_id"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 outline-none transition">

                        <option value="">
                            Seleccionar sucursal
                        </option>

                        @foreach($branches as $branch)

                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <!-- PUESTO -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Puesto
                    </label>

                    <select name="job_position_id"
                            id="job_position_id"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 outline-none transition">

                        <option value="">
                            Seleccionar puesto
                        </option>

                    </select>
                </div>

                <!-- DEPARTAMENTO -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Departamento
                    </label>

                    <input name="department"
                        class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500 outline-none transition">
                </div>

                <!-- FECHA INGRESO -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Fecha de ingreso
                    </label>

                    <input type="date"
                           name="hire_date"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

            </div>

        </div>

        <!-- 🟡 DATOS FISCALES -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">

            <div class="flex items-center gap-3 mb-6">

                <div class="w-11 h-11 rounded-xl bg-yellow-100 flex items-center justify-center text-xl">
                    🧾
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-800">
                        Datos fiscales
                    </h2>

                    <p class="text-sm text-slate-500">
                        Información legal y bancaria
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                <!-- CURP -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        CURP
                    </label>

                    <input name="curp"
                           class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- RFC -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        RFC
                    </label>

                    <input name="rfc"
                           class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- IMSS -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        IMSS
                    </label>

                    <input name="imss"
                           class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

                <!-- CLABE -->
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Cuenta CLABE
                    </label>

                    <input name="clabe"
                           class="uppercase w-full border border-slate-200 rounded-xl px-4 py-3
                                  focus:ring-2 focus:ring-blue-500
                                  focus:border-blue-500 outline-none transition">
                </div>

            </div>

        </div>

        <!-- 📸 ARCHIVOS -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">

            <div class="flex items-center gap-3 mb-6">

                <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center text-xl">
                    📁
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-800">
                        Archivos
                    </h2>

                    <p class="text-sm text-slate-500">
                        Foto y documentos del empleado
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- FOTO -->
                <div>

                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Fotografía
                    </label>

                    <input type="file"
                           name="photo"
                           class="w-full border border-dashed border-slate-300
                                  rounded-xl px-4 py-4 bg-slate-50">

                </div>

                <!-- DOCUMENTOS -->
                <div>

                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Documentos
                    </label>

                    <input type="file"
                           name="files[]"
                           multiple
                           class="w-full border border-dashed border-slate-300
                                  rounded-xl px-4 py-4 bg-slate-50">

                </div>

            </div>

        </div>

        <!-- BOTONES -->
        <div class="flex justify-end gap-4 pb-10">

            <a href="/rh"
               class="px-6 py-3 rounded-xl border border-slate-300
                      bg-white hover:bg-slate-50 transition text-slate-700">

                Cancelar

            </a>

            <button
                class="bg-blue-600 hover:bg-blue-700
                       text-white px-6 py-3 rounded-xl
                       font-medium shadow-sm transition">

                Guardar empleado

            </button>

        </div>

    </div>

    </form>

</div>

<script>

    const branches = @json(
        $branches->load('jobPositions')
    );

    const branchSelect = document.getElementById('branch_id');
    const positionSelect = document.getElementById('job_position_id');

    branchSelect.addEventListener('change', function () {

        const branchId = this.value;

        positionSelect.innerHTML =
            '<option value="">Seleccionar puesto</option>';

        if (!branchId) return;

        const branch = branches.find(
            b => b.id == branchId
        );

        if (!branch) return;

        branch.job_positions.forEach(position => {

            const option = document.createElement('option');

            option.value = position.id;
            option.textContent = position.name;

            positionSelect.appendChild(option);

        });

    });

</script>

@endsection
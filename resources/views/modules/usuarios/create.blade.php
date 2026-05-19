@extends('layouts.erp')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Crear Usuario</h1>
        <p class="mt-1 text-sm text-gray-500">
            Configura la información, roles y permisos del usuario.
        </p>
    </div>

    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <div class="space-y-6">

            {{-- DATOS DEL USUARIO --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19a3 3 0 10-6 0m6 0H9m6 0a3 3 0 11-6 0m6 0a6 6 0 10-12 0m12 0h6m-6 0V9a3 3 0 00-6 0v10" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Información del usuario</h2>
                        <p class="text-sm text-gray-500">Datos principales y credenciales de acceso.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input type="text" name="name"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>

                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 pr-11 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">

                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rol</label>

                        <select name="role_id"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- PERMISOS --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="h-12 w-12 rounded-full bg-violet-50 flex items-center justify-center text-violet-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.105-.672 2-1.5 2S9 12.105 9 11s.672-2 1.5-2 1.5.895 1.5 2zm0 0v1m0 4a8 8 0 10-8-8 8 8 0 008 8z" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Permisos de módulos</h2>
                        <p class="text-sm text-gray-500">Activa el acceso por módulo y submódulo.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($modules as $module)
                        <div class="rounded-2xl border border-gray-200 bg-gray-50/70 p-5 hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="font-semibold text-gray-900">{{ $module->name }}</h3>
                            </div>

                            <label class="mt-4 flex items-center gap-2 text-sm text-gray-700">
                                <input
                                    type="checkbox"
                                    class="module-view w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    data-module="{{ $module->slug }}"
                                    name="permissions[{{ $module->id }}][view]">
                                <span>Ver</span>
                            </label>

                            @if($module->children->count())
                                <div class="mt-4 module-children hidden rounded-xl border border-blue-100 bg-white p-4" data-parent="{{ $module->slug }}">
                                    <h4 class="font-semibold text-sm text-gray-700 mb-3">Submódulos</h4>

                                    <div class="space-y-3">
                                        @foreach($module->children as $child)
                                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                                                <h5 class="font-medium text-gray-800 mb-3">{{ $child->name }}</h5>

                                                <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
                                                    <label class="flex items-center gap-2">
                                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="permissions[{{ $child->id }}][view]">
                                                        <span>Ver</span>
                                                    </label>

                                                    <label class="flex items-center gap-2">
                                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="permissions[{{ $child->id }}][create]">
                                                        <span>Crear</span>
                                                    </label>

                                                    <label class="flex items-center gap-2">
                                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="permissions[{{ $child->id }}][edit]">
                                                        <span>Editar</span>
                                                    </label>

                                                    <label class="flex items-center gap-2">
                                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="permissions[{{ $child->id }}][delete]">
                                                        <span>Eliminar</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- MANTENIMIENTO --}}
            <div id="maintenance-access" class="hidden">
                <div class="bg-amber-50 border border-amber-200 rounded-2xl shadow-sm p-6">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.827 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.827 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.827-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.827-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Acceso a sucursales y áreas</h2>
                            <p class="text-sm text-gray-600">Este bloque aparece únicamente para el módulo de mantenimiento.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div class="rounded-2xl bg-white border border-amber-100 p-5">
                            <h3 class="font-semibold text-gray-800 mb-4">Sucursales</h3>

                            <label class="flex items-center gap-2 mb-4 font-medium text-gray-700">
                                <input type="checkbox" id="select-all-branches" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span>Seleccionar todas las sucursales</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($branches as $branch)
                                    <label class="border border-gray-200 rounded-xl p-3 block bg-gray-50 hover:bg-gray-100 transition">
                                        <input type="checkbox"
                                               class="branch-checkbox w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2 align-middle"
                                               data-branch="{{ $branch->id }}"
                                               name="branches[]"
                                               value="{{ $branch->id }}">
                                        <span class="text-gray-700">{{ $branch->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-2xl bg-white border border-amber-100 p-5">
                            <h3 class="font-semibold text-gray-800 mb-4">Áreas</h3>

                            <label class="flex items-center gap-2 mb-4 font-medium text-gray-700">
                                <input type="checkbox" id="select-all-areas" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span>Seleccionar todas las áreas</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($areas as $area)
                                    <label class="border border-gray-200 rounded-xl p-3 block area-item bg-gray-50 hover:bg-gray-100 transition"
                                           data-branch="{{ $area->branch_id }}"
                                           style="display:none">
                                        <input type="checkbox" name="areas[]" value="{{ $area->id }}" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2 align-middle">
                                        <span class="text-gray-700">{{ $area->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ACCIONES --}}
            <div class="pt-2">
                <button class="inline-flex items-center justify-center rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 shadow-md transition">
                    Guardar Usuario
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    const maintenanceSection = document.getElementById("maintenance-access");
    const maintenanceChildren = document.querySelectorAll(".maintenance-children");

    document.querySelectorAll(".module-view").forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        const slug = this.dataset.module;

        // 1) Mostrar/ocultar submódulos de cualquier módulo padre
        document.querySelectorAll(`.module-children[data-parent="${slug}"]`).forEach(function (el) {
            if (checkbox.checked) {
                el.classList.remove("hidden");
            } else {
                el.classList.add("hidden");
            }
        });

        // 2) Lógica especial solo para mantenimiento
        if (slug === "mantenimiento") {
            if (checkbox.checked) {
                maintenanceSection.classList.remove("hidden");
            } else {
                maintenanceSection.classList.add("hidden");

                document.querySelectorAll(".branch-checkbox").forEach(function (branch) {
                    branch.checked = false;
                    branch.dispatchEvent(new Event("change"));
                });

                document.querySelectorAll(".area-item input").forEach(function (area) {
                    area.checked = false;
                });

                const selectAllBranches = document.getElementById("select-all-branches");
                const selectAllAreas = document.getElementById("select-all-areas");
                if (selectAllBranches) selectAllBranches.checked = false;
                if (selectAllAreas) selectAllAreas.checked = false;
            }
        }
    });
});


        // Mostrar áreas según sucursal seleccionada
        document.querySelectorAll(".branch-checkbox").forEach(function(branch){

            branch.addEventListener("change", function(){

                const branchId = this.dataset.branch;

                document.querySelectorAll(".area-item").forEach(function(area){

                    if(area.dataset.branch === branchId){

                        if(branch.checked){
                            area.style.display = "block";
                        }else{
                            area.style.display = "none";
                            area.querySelector("input").checked = false;
                        }

                    }

                });

            });

        });

    const selectAllBranches = document.getElementById("select-all-branches");

    if(selectAllBranches){
        selectAllBranches.addEventListener("change", function(){

            document.querySelectorAll(".branch-checkbox").forEach(function(branch){

                branch.checked = selectAllBranches.checked;

                // disparar evento manual para que se muestren áreas
                branch.dispatchEvent(new Event('change'));

            });

        });
    }

    const selectAllAreas = document.getElementById("select-all-areas");

    if(selectAllAreas){
        selectAllAreas.addEventListener("change", function(){

            document.querySelectorAll(".area-item input").forEach(function(area){
                area.checked = selectAllAreas.checked;
            });

        });
    }

    function togglePassword() {

        const input = document.getElementById('password');

        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }

    }
</script>

@endsection
@extends('layouts.erp')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
Crear Usuario
</h1>

    <form method="POST" action="{{ route('usuarios.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium">Nombre</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" placeholder="Dejar vacío para no cambiar">
        </div>

        <div>
            <label class="block text-sm font-medium">Rol</label>

            <select name="role_id" class="w-full border rounded p-2">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}"
                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>

        </div>

    </div>


    <h2 class="text-lg font-semibold mt-8 mb-4">
    Permisos de módulos
    </h2>

    <div class="grid grid-cols-3 gap-4">

        @foreach($modules as $module)

            <div class="border rounded p-4">

                <h3 class="font-semibold mb-2">
                    {{ $module->name }}
                </h3>

                <label class="block">
                    <input type="checkbox"
                        class="module-view"
                        data-module="{{ $module->slug }}"
                        name="permissions[{{ $module->id }}][view]"
                        {{ isset($userPermissions[$module->id]) && $userPermissions[$module->id]->can_view ? 'checked' : '' }}>
                    Ver
                </label>

                <label class="block">
                    <input type="checkbox"
                        name="permissions[{{ $module->id }}][create]"
                        {{ isset($userPermissions[$module->id]) && $userPermissions[$module->id]->can_create ? 'checked' : '' }}>
                    Crear
                </label>

                <label class="block">
                    <input type="checkbox"
                        name="permissions[{{ $module->id }}][edit]"
                        {{ isset($userPermissions[$module->id]) && $userPermissions[$module->id]->can_edit ? 'checked' : '' }}>
                    Editar
                </label>

                <label class="block">
                    <input type="checkbox"
                        name="permissions[{{ $module->id }}][delete]"
                        {{ isset($userPermissions[$module->id]) && $userPermissions[$module->id]->can_delete ? 'checked' : '' }}>
                    Eliminar
                </label>

            </div>

        @endforeach

    </div>

    <div id="maintenance-access" class="hidden">

    <h2 class="text-lg font-semibold mt-8 mb-4">
    Acceso a sucursales
    </h2>

    <div class="grid grid-cols-3 gap-4">

        @foreach($branches as $branch)

        <label class="border rounded p-3 block">
            <input type="checkbox"
            class="branch-checkbox"
            data-branch="{{ $branch->id }}"
            name="branches[]"
            value="{{ $branch->id }}"
            {{ in_array($branch->id, $userBranches) ? 'checked' : '' }}>
            {{ $branch->name }}
        </label>

        @endforeach

    </div>


    <h2 class="text-lg font-semibold mt-8 mb-4">
    Acceso a áreas
    </h2>

    <div class="grid grid-cols-3 gap-4">

        @foreach($areas as $area)

        <label class="border rounded p-3 block area-item"
               data-branch="{{ $area->branch_id }}"
               style="display:none">

            <input type="checkbox"
            name="areas[]"
            value="{{ $area->id }}"
            {{ in_array($area->id, $userAreas) ? 'checked' : '' }}>
            {{ $area->name }}

        </label>

        @endforeach

    </div>

</div>

        <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">
        Guardar Usuario
        </button>

    </form>
<script>
document.addEventListener("DOMContentLoaded", function(){

    const maintenanceSection = document.getElementById("maintenance-access");

    // 🔹 Mostrar/ocultar sucursales por módulo mantenimiento
    document.querySelectorAll(".module-view").forEach(function(checkbox){

        checkbox.addEventListener("change", function(){

            if(this.dataset.module === "mantenimiento"){

                if(this.checked){
                    maintenanceSection.classList.remove("hidden");
                } else {
                    maintenanceSection.classList.add("hidden");

                    // limpiar selecciones si se desactiva
                    document.querySelectorAll(".branch-checkbox").forEach(cb => cb.checked = false);
                    document.querySelectorAll(".area-item input").forEach(cb => cb.checked = false);
                    document.querySelectorAll(".area-item").forEach(el => el.style.display = "none");
                }

            }

        });

    });


    // 🔹 Mostrar áreas según sucursal seleccionada
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


    // 🔥 ESTADO INICIAL (cuando cargas edit)

    // Mostrar mantenimiento si ya está activo
    document.querySelectorAll(".module-view:checked").forEach(function(checkbox){

        if(checkbox.dataset.module === "mantenimiento"){
            maintenanceSection.classList.remove("hidden");
        }

    });

    // Mostrar áreas ya seleccionadas por sucursal
    document.querySelectorAll(".branch-checkbox:checked").forEach(function(branch){

        const branchId = branch.dataset.branch;

        document.querySelectorAll(".area-item").forEach(function(area){

            if(area.dataset.branch === branchId){
                area.style.display = "block";
            }

        });

    });

});
</script>

@endsection
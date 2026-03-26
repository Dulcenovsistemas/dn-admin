<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Module;
use App\Models\Branch;
use App\Models\Area;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\ModulePermission;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return view('modules.usuarios.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all();
        $modules = Module::all();
        $branches = Branch::all();
        $areas = Area::all();

        return view('modules.usuarios.create', compact(
            'roles',
            'modules',
            'branches',
            'areas'
        ));
    }


    public function edit($id)
    {
        $user = User::with(['branches', 'areas', 'modulePermissions'])->findOrFail($id);

        // módulos
        $modules = Module::all();

        // roles 🔥 (esto faltaba)
        $roles = Role::all();

        // permisos
        $userPermissions = $user->modulePermissions->keyBy('module_id');

        // sucursales y áreas
        $branches = Branch::all();
        $areas = Area::all();

        // seleccionados
        $userBranches = $user->branches->pluck('id')->toArray();
        $userAreas = $user->areas->pluck('id')->toArray();

        return view('modules.usuarios.edit', compact(
            'user',
            'modules',
            'roles', // 👈 IMPORTANTE
            'userPermissions',
            'branches',
            'areas',
            'userBranches',
            'userAreas'
        ));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            // 🔹 1. Actualizar datos básicos
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // 🔥 2. Permisos de módulos

            // borrar permisos actuales
            ModulePermission::where('user_id', $user->id)->delete();

            if ($request->permissions) {

                foreach ($request->permissions as $moduleId => $perms) {

                    ModulePermission::create([
                        'user_id'    => $user->id,
                        'module_id'  => $moduleId,
                        'can_view'   => isset($perms['view']),
                        'can_create' => isset($perms['create']),
                        'can_edit'   => isset($perms['edit']),
                        'can_delete' => isset($perms['delete']),
                    ]);

                }

            }

            // 🏢 3. Sucursales (many-to-many)
            $user->branches()->sync($request->branches ?? []);

            // 🧩 4. Áreas (many-to-many)
            $user->areas()->sync($request->areas ?? []);

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado correctamente');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        if($request->has('permissions')){

            foreach($request->permissions as $module_id => $perms){

                ModulePermission::create([
                    'user_id' => $user->id,
                    'module_id' => $module_id,
                    'can_view' => !empty($perms['view']) ? 1 : 0,
                    'can_create' => !empty($perms['create']) ? 1 : 0,
                    'can_edit' => !empty($perms['edit']) ? 1 : 0,
                    'can_delete' => !empty($perms['delete']) ? 1 : 0
                ]);

            }

        }

        if($request->branches){

            foreach($request->branches as $branch){

                DB::table('user_branches')->insert([
                    'user_id' => $user->id,
                    'branch_id' => $branch
                ]);

            }

        }

            if($request->areas){

                foreach($request->areas as $area){

                    DB::table('user_areas')->insert([
                        'user_id' => $user->id,
                        'area_id' => $area
                    ]);

            }

        }

            return redirect('/usuarios');

    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);

            // 🔥 eliminar permisos
            ModulePermission::where('user_id', $user->id)->delete();

            // 🔥 eliminar relaciones
            $user->branches()->detach();
            $user->areas()->detach();

            // 🔥 eliminar usuario
            $user->delete();

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario eliminado correctamente');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}

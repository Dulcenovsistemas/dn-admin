<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Area;
use App\Models\JobPosition;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('modules.sucursales.index', compact('branches'));
    }


    public function create()
    {
        return view('modules.sucursales.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        Branch::create([
            'name' => $request->name,
            'city' => $request->city,
        ]);

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal creada correctamente');
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);

        $branch->delete();

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal eliminada correctamente');
    }


    public function edit($id)
    {
        $branch = Branch::with(['areas', 'jobPositions'])->findOrFail($id);

        $jobPositions = JobPosition::all();
        $branchJobs = $branch->jobPositions->pluck('id')->toArray();

        return view('modules.sucursales.edit', compact(
            'branch',
            'jobPositions',
            'branchJobs'
        ));
    }

   

    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->jobPositions()->sync($request->job_positions ?? []);

        // 🔹 actualizar sucursal
        $branch->update([
            'name' => $request->name
        ]);

        // 🔥 1. actualizar áreas existentes
        if ($request->areas_existing) {
            foreach ($request->areas_existing as $areaId => $name) {
                Area::where('id', $areaId)->update([
                    'name' => $name
                ]);
            }
        }

        // 🔥 2. crear nuevas áreas
        if ($request->areas_new) {
            foreach ($request->areas_new as $name) {
                if ($name) {
                    Area::create([
                        'name' => $name,
                        'branch_id' => $branch->id
                    ]);
                }
            }
        }

        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal actualizada correctamente');
    }
}
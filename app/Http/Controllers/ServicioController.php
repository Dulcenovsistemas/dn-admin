<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Area;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $sucursales = auth()->user()
            ->branches()
            ->with('areas')
            ->get();

        return view('modules.mantenimiento.servicios.index', compact('sucursales'));
    }

    public function porSucursal($id)
    {
        $sucursal = Branch::with('areas.servicios')->findOrFail($id);

        return view('modules.mantenimiento.servicios.sucursal', compact('sucursal'));
    }

    public function porArea($id)
    {
        $area = Area::with('servicios.sucursal')->findOrFail($id);

        return view('modules.mantenimiento.servicios.area', compact('area'));
    }

    public function create($areaId)
    {
        $user = auth()->user();

        $area = $user->areas()
            ->with('branch')
            ->where('areas.id', $areaId)
            ->firstOrFail();

        $sucursal = $area->branch;

        return view('modules.mantenimiento.servicios.create', compact('area', 'sucursal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sucursal_id'     => 'required|exists:branches,id',
            'area_id'         => 'required|exists:areas,id',
            'tipo_servicio'   => 'required|string|max:255',
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'proveedor'       => 'nullable|string|max:255',
            'numero_contrato' => 'nullable|string|max:255',
            'costo_mensual'   => 'nullable|numeric',
            'fecha_inicio'    => 'nullable|date',
            'estatus'         => 'required|string|max:255',
        ]);

        Servicio::create([
            'sucursal_id'     => $request->sucursal_id,
            'area_id'         => $request->area_id,
            'tipo_servicio'   => $request->tipo_servicio,
            'nombre'          => $request->nombre,
            'descripcion'     => $request->descripcion,
            'proveedor'       => $request->proveedor,
            'numero_contrato' => $request->numero_contrato,
            'costo_mensual'   => $request->costo_mensual,
            'fecha_inicio'    => $request->fecha_inicio,
            'estatus'         => $request->estatus,
        ]);

        return redirect()
            ->route('servicios.area', $request->area_id)
            ->with('success', 'Servicio registrado correctamente');
    }

    public function show($id)
    {
        $servicio = Servicio::with(['sucursal', 'area'])->findOrFail($id);

        return view('modules.mantenimiento.servicios.show', compact('servicio'));
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);

        $user = auth()->user();

        if (!$user->branches->contains($servicio->sucursal_id)) {
            return back()->with('error', 'No tienes permiso para editar este servicio');
        }

        $sucursales = $user->branches;
        $areas = $user->areas;

        return view(
            'modules.mantenimiento.servicios.edit',
            compact('servicio', 'sucursales', 'areas')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_servicio'   => 'required|string|max:255',
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'proveedor'       => 'nullable|string|max:255',
            'numero_contrato' => 'nullable|string|max:255',
            'costo_mensual'   => 'nullable|numeric',
            'fecha_inicio'    => 'nullable|date',
            'estatus'         => 'required|string|max:255',
        ]);

        $servicio = Servicio::findOrFail($id);

        $user = auth()->user();

        if (!$user->branches->contains($servicio->sucursal_id)) {
            return back()->with('error', 'No tienes permiso para modificar este servicio');
        }

        try {

            $servicio->update([
                'tipo_servicio'   => $request->tipo_servicio,
                'nombre'          => $request->nombre,
                'descripcion'     => $request->descripcion,
                'proveedor'       => $request->proveedor,
                'numero_contrato' => $request->numero_contrato,
                'costo_mensual'   => $request->costo_mensual,
                'fecha_inicio'    => $request->fecha_inicio,
                'estatus'         => $request->estatus,
            ]);

            return redirect()
                ->route('servicios.show', $servicio->id)
                ->with('success', 'Servicio actualizado correctamente');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el servicio');
        }
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);

        $user = auth()->user();

        if (!$user->branches->contains($servicio->sucursal_id)) {
            return back()->with('error', 'No tienes permiso para eliminar este servicio');
        }

        try {

            $areaId = $servicio->area_id;

            $servicio->delete();

            return redirect()
                ->route('servicios.area', $areaId)
                ->with('success', 'Servicio eliminado correctamente');

        } catch (\Exception $e) {

            return back()
                ->with('error', 'Error al eliminar el servicio');
        }
    }


}
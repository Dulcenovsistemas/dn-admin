<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(Area $area)
    {
        $area->load(['sucursal', 'servicios']);

        return view('modules.mantenimiento.servicios.index', compact('area'));
    }

    public function create()
    {
        $sucursales = Branch::all();
        $areas = Area::all();

        return view('servicios.create', compact('sucursales', 'areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sucursal_id' => ['required', 'exists:branches,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'tipo_servicio' => ['required', 'string'],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'proveedor' => ['nullable', 'string', 'max:255'],
            'numero_contrato' => ['nullable', 'string', 'max:255'],
            'costo_mensual' => ['nullable', 'numeric', 'min:0'],
            'fecha_inicio' => ['nullable', 'date'],
            'estatus' => ['required', 'in:Activo,Suspendido,Cancelado'],
        ]);

        Servicio::create($data);

        return redirect()->route('servicios.index')->with('success', 'Servicio creado correctamente.');
    }

    public function show(Servicio $servicio)
    {
        $servicio->load(['sucursal', 'area']);

        return view('servicios.show', compact('servicio'));
    }

    public function edit(Servicio $servicio)
    {
        $sucursales = Branch::all();
        $areas = Area::all();

        return view('servicios.edit', compact('servicio', 'sucursales', 'areas'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'sucursal_id' => ['required', 'exists:branches,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'tipo_servicio' => ['required', 'string'],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'proveedor' => ['nullable', 'string', 'max:255'],
            'numero_contrato' => ['nullable', 'string', 'max:255'],
            'costo_mensual' => ['nullable', 'numeric', 'min:0'],
            'fecha_inicio' => ['nullable', 'date'],
            'estatus' => ['required', 'in:Activo,Suspendido,Cancelado'],
        ]);

        $servicio->update($data);

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }

    public function porArea(Area $area)
    {
        $area->load(['sucursal', 'servicios']);

        return view('modules.mantenimiento.servicios.index', compact('area'));
    }
}
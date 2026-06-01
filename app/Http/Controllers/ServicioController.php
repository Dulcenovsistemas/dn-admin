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
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Area;
use App\Models\Branch;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sucursales = Branch::with('areas.equipos')->get();

        return view('modules.mantenimiento.equipos.index', compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        // 🔥 sucursales asignadas al usuario
        $sucursales = $user->branches;

        // 🔥 áreas asignadas al usuario
        $areas = $user->areas;

        return view('modules.mantenimiento.equipos.create', compact('sucursales','areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🔹 VALIDACIÓN
        $request->validate([
            'sucursal_id' => 'required|exists:branches,id',
            'area_id' => 'required|exists:areas,id',
            'nombre' => 'required|string|max:255',
        ]);

        // 🔹 OBTENER MODELOS
        $sucursal = Branch::findOrFail($request->sucursal_id);
        $area = Area::findOrFail($request->area_id);

        // 🔥 GENERAR CÓDIGO (FAB-BAT-001)
        $sucursalCode = strtoupper(Str::substr($sucursal->name, 0, 3));
        $areaCode = strtoupper(Str::substr($area->name, 0, 3));

        $count = Equipo::where('sucursal_id', $sucursal->id)
            ->where('area_id', $area->id)
            ->count() + 1;

        $numero = str_pad($count, 3, '0', STR_PAD_LEFT);

        $id = "$sucursalCode-$areaCode-$numero";

        // 🔥 GENERAR QR
        $qrPath = 'qrcodes/'.$id.'.svg';

        // crear carpeta si no existe
        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0777, true);
        }

        QrCode::format('svg')
            ->size(300)
            ->generate(url('/equipos/'.$id), public_path($qrPath));

        // 🔹 GUARDAR
        Equipo::create([
            'id' => $id,
            'sucursal_id' => $request->sucursal_id,
            'area_id' => $request->area_id,
            'nombre' => $request->nombre,
            'marca_modelo' => $request->marca_modelo,
            'numero_serie' => $request->numero_serie,
            'fecha_adquisicion' => $request->fecha_adquisicion,
            'responsable' => $request->responsable,
            'especificaciones' => $request->especificaciones,
            'qr_codigo' => $qrPath
        ]);

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo registrado correctamente');
    }


    public function porSucursal($id)
    {
        $sucursal = Branch::with('areas.equipos')->findOrFail($id);

        return view('modules.mantenimiento.equipos.sucursal', compact('sucursal'));
    }

    public function porArea($id)
    {
        $area = Area::with('equipos.sucursal')->findOrFail($id);

        return view('modules.mantenimiento.equipos.area', compact('area'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

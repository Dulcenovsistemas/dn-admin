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
    public function index()
    {
        $sucursales = Branch::with('areas.equipos')->get();

        return view('modules.mantenimiento.equipos.index', compact('sucursales'));
    }

    public function create()
    {
        $user = auth()->user();

        $sucursales = $user->branches;
        $areas = $user->areas;

        return view('modules.mantenimiento.equipos.create', compact('sucursales','areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:branches,id',
            'area_id' => 'required|exists:areas,id',
            'nombre' => 'required|string|max:255',
            'marca_modelo' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'fecha_adquisicion' => 'nullable|date',
            'responsable' => 'nullable|string|max:255',
            'especificaciones' => 'nullable|string',
        ]);

        try {

            $sucursal = Branch::findOrFail($request->sucursal_id);
            $area = Area::findOrFail($request->area_id);

            $sucursalCode = strtoupper(Str::substr($sucursal->name, 0, 3));
            $areaCode = strtoupper(Str::substr($area->name, 0, 3));

            $count = Equipo::where('sucursal_id', $sucursal->id)
                ->where('area_id', $area->id)
                ->count() + 1;

            $numero = str_pad($count, 3, '0', STR_PAD_LEFT);

            $id = "$sucursalCode-$areaCode-$numero";

            $qrPath = 'qrcodes/'.$id.'.svg';

            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0777, true);
            }

            QrCode::format('svg')
                ->size(300)
                ->generate(url('/equipos/'.$id), public_path($qrPath));

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

            return redirect()->route('equipos.area', $request->area_id)
                    ->with('success', 'Equipo registrado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al registrar el equipo');
        }
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

    public function show($id)
    {
        $equipo = Equipo::with(['sucursal', 'area'])->findOrFail($id);

        return view('modules.mantenimiento.equipos.show', compact('equipo'));
    }

    public function edit($id)
    {
        $equipo = Equipo::findOrFail($id);

        $user = auth()->user();

        // 🔒 seguridad
        if (!$user->branches->contains($equipo->sucursal_id)) {
            return back()->with('error', 'No tienes permiso para editar este equipo');
        }

        $sucursales = $user->branches;
        $areas = $user->areas;

        return view('modules.mantenimiento.equipos.edit', compact('equipo', 'sucursales', 'areas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:branches,id',
            'area_id' => 'required|exists:areas,id',
            'nombre' => 'required|string|max:255',
            'marca_modelo' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'fecha_adquisicion' => 'nullable|date',
            'responsable' => 'nullable|string|max:255',
            'especificaciones' => 'nullable|string',
        ]);

        $equipo = Equipo::findOrFail($id);

        $user = auth()->user();

        if (!$user->branches->contains($equipo->sucursal_id)) {
            return back()->with('error', 'No tienes permiso para modificar este equipo');
        }

        try {

            $cambioUbicacion = 
                $equipo->sucursal_id != $request->sucursal_id ||
                $equipo->area_id != $request->area_id;

            if ($cambioUbicacion) {

                $sucursal = Branch::findOrFail($request->sucursal_id);
                $area = Area::findOrFail($request->area_id);

                $sucursalCode = strtoupper(Str::substr($sucursal->name, 0, 3));
                $areaCode = strtoupper(Str::substr($area->name, 0, 3));

                $count = Equipo::where('sucursal_id', $sucursal->id)
                    ->where('area_id', $area->id)
                    ->count() + 1;

                $numero = str_pad($count, 3, '0', STR_PAD_LEFT);

                $nuevoId = "$sucursalCode-$areaCode-$numero";

                $qrPath = 'qrcodes/'.$nuevoId.'.svg';

                if (!file_exists(public_path('qrcodes'))) {
                    mkdir(public_path('qrcodes'), 0777, true);
                }

                QrCode::format('svg')
                    ->size(300)
                    ->generate(url('/equipos/'.$nuevoId), public_path($qrPath));

                if ($equipo->qr_codigo && file_exists(public_path($equipo->qr_codigo))) {
                    try {
                        unlink(public_path($equipo->qr_codigo));
                    } catch (\Exception $e) {}
                }

                $equipo->update([
                    'id' => $nuevoId,
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

                return redirect()->route('equipos.show', $nuevoId)
                    ->with('success', 'Equipo actualizado correctamente');
            }

            $equipo->update([
                'sucursal_id' => $request->sucursal_id,
                'area_id' => $request->area_id,
                'nombre' => $request->nombre,
                'marca_modelo' => $request->marca_modelo,
                'numero_serie' => $request->numero_serie,
                'fecha_adquisicion' => $request->fecha_adquisicion,
                'responsable' => $request->responsable,
                'especificaciones' => $request->especificaciones,
            ]);

            return redirect()->route('equipos.show', $equipo->id)
                ->with('success', 'Equipo actualizado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el equipo');
        }
    }

    public function destroy($id)
    {
        $equipo = Equipo::findOrFail($id);

        $user = auth()->user();

        if (!$user->branches->contains($equipo->sucursal_id)) {
            return back()->with('error', 'No tienes permiso para eliminar este equipo');
        }

        try {

            if ($equipo->qr_codigo && file_exists(public_path($equipo->qr_codigo))) {
                try {
                    unlink(public_path($equipo->qr_codigo));
                } catch (\Exception $e) {}
            }

            $equipo->delete();

           return redirect()->route('equipos.area', $equipo->area_id)
                ->with('success', 'Equipo eliminado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el equipo');
        }
    }
}
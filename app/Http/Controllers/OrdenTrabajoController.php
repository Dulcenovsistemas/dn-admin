<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OrdenTrabajo;

use App\Models\Branch;
use App\Models\Equipo;
use App\Models\Servicio;
use App\Models\Area;

use App\Models\OrdenTrabajoEvidencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrdenTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordenes = OrdenTrabajo::with([
            'sucursal',
            'solicitante',
            'equipo',
            'servicio'
        ])
        ->latest()
        ->paginate(10);

        return view('modules.mantenimiento.ordenes.index', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sucursales = Branch::orderBy('name')->get();
        $equipos = Equipo::orderBy('nombre')->get();
        $servicios = Servicio::orderBy('nombre')->get();

        return view('modules.mantenimiento.ordenes.create', compact(
            'sucursales',
            'equipos',
            'servicios'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'branch_id' => 'required',
            'area_id' => 'required',
            'categoria' => 'required',
            'tipo_mantenimiento' => 'required',
            'prioridad' => 'required',
            'descripcion' => 'required',
        ]);

        // Obtener el último folio
        $ultimo = OrdenTrabajo::latest('id')->first();

        if ($ultimo) {
            $numero = intval(substr($ultimo->folio, 3)) + 1;
        } else {
            $numero = 1;
        }

        $folio = 'OT-' . str_pad($numero, 6, '0', STR_PAD_LEFT);

        $orden = OrdenTrabajo::create([
            'folio' => $folio,
            'branch_id' => $request->branch_id,
            'area_id' => $request->area_id,
            'user_id' => Auth::id(),
            'categoria' => $request->categoria,
            'equipo_id' => $request->equipo_id,
            'servicio_id' => $request->servicio_id,
            'tipo_mantenimiento' => $request->tipo_mantenimiento,
            'prioridad' => $request->prioridad,
            'estado' => 'Pendiente',
            'descripcion' => $request->descripcion,
            'fecha_programada' => $request->fecha_programada,
            'created_by' => Auth::id(),
            
        ]);

        if ($request->hasFile('evidencias')) {

            foreach ($request->file('evidencias') as $archivo) {

                $ruta = $archivo->store('ordenes', 'public');

                OrdenTrabajoEvidencia::create([
                    'orden_trabajo_id' => $orden->id,
                    'archivo' => $ruta,
                ]);
            }
        }

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'La orden fue creada correctamente.');
    }


    public function areas($branch)
    {
        return Area::where('branch_id', $branch)
            ->orderBy('name')
            ->get();
    }

    public function equiposServicios(Request $request)
    {
        if ($request->categoria == 'Equipo') {

            return Equipo::where('area_id', $request->area_id)
                ->orderBy('nombre')
                ->get();

        }

        return Servicio::where('area_id', $request->area_id)
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(OrdenTrabajo $ordene)
    {
       $ordene->load([
            'sucursal',
            'area',
            'solicitante',
            'equipo',
            'servicio',
            'evidencias',
            'creador',
            'cerradoPor',
            'tecnico',
            'reporte',
        ]);

        return view(
            'modules.mantenimiento.ordenes.show',
            compact('ordene')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrdenTrabajo $ordene)
    {
        $sucursales = Branch::orderBy('name')->get();

        $areas = Area::where('branch_id', $ordene->branch_id)
            ->orderBy('name')
            ->get();

        $equipos = Equipo::where('area_id', $ordene->area_id)
            ->orderBy('nombre')
            ->get();

        $servicios = Servicio::where('area_id', $ordene->area_id)
            ->orderBy('nombre')
            ->get();

        return view(
            'modules.mantenimiento.ordenes.edit',
            compact(
                'ordene',
                'sucursales',
                'areas',
                'equipos',
                'servicios'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrdenTrabajo $ordene)
    {
        $request->validate([
            'branch_id' => 'required',
            'area_id' => 'required',
            'categoria' => 'required',
            'tipo_mantenimiento' => 'required',
            'prioridad' => 'required',
            'descripcion' => 'required',
        ]);

        $equipoId = null;
        $servicioId = null;

        if ($request->categoria == 'Equipo') {
            $equipoId = $request->equipo_id;
        } else {
            $servicioId = $request->servicio_id;
        }

        $ordene->update([
            'branch_id' => $request->branch_id,
            'area_id' => $request->area_id,
            'categoria' => $request->categoria,
            'equipo_id' => $equipoId,
            'servicio_id' => $servicioId,
            'tipo_mantenimiento' => $request->tipo_mantenimiento,
            'prioridad' => $request->prioridad,
            'estado' => $request->estado,
            'tecnico' => $request->tecnico,
            'descripcion' => $request->descripcion,
            'solucion' => $request->solucion,
            'observaciones' => $request->observaciones,
            'costo' => $request->costo,
            'fecha_programada' => $request->fecha_programada,
            'fecha_inicio' => $request->fecha_inicio,
        ]);

        if ($request->hasFile('evidencias')) {

            foreach ($request->file('evidencias') as $archivo) {

                $ruta = $archivo->store('ordenes', 'public');

                OrdenTrabajoEvidencia::create([
                    'orden_trabajo_id' => $ordene->id,
                    'archivo' => $ruta,
                ]);
            }
        }

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'La orden fue actualizada correctamente.');
    }


    public function finalizar(OrdenTrabajo $ordene)
    {
        if ($ordene->tecnico_id != auth()->id()) {
            abort(403);
        }

        // Si ya existe un reporte no permitir crear otro
        if ($ordene->reporte) {

            return back()->with(
                'error',
                'Esta orden ya cuenta con un reporte.'
            );

        }

        return redirect()->route(
            'reportes.create',
            $ordene
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function tomar(OrdenTrabajo $ordene)
    {
        // Si ya tiene técnico, no permitir tomarla nuevamente
        if ($ordene->tecnico_id) {

            return back()->with('error', 'La orden ya fue tomada por otro técnico.');

        }

        $ordene->update([
            'tecnico_id'   => auth()->id(),
            'estado'       => 'En proceso',
            'fecha_inicio' => now(),
        ]);

        return redirect()
            ->route('ordenes.show', $ordene)
            ->with('success', 'La orden fue tomada correctamente.');
    }
}

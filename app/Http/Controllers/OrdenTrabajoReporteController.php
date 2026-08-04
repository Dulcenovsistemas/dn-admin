<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenTrabajo;
use App\Models\OrdenTrabajoReporte;

class OrdenTrabajoReporteController extends Controller
{
    public function create(OrdenTrabajo $ordene)
    {
        return view(
            'modules.mantenimiento.ordenes.cerrar_orden',
            compact('ordene')
        );
    }


     public function store(Request $request, OrdenTrabajo $ordene)
    {
        $request->validate([

            'diagnostico'   => 'required',

            'solucion'      => 'required',

            'materiales'    => 'nullable',

            'observaciones' => 'nullable',

            'costo'         => 'required|numeric|min:0',

        ]);

        // Crear reporte
        $reporte = new OrdenTrabajoReporte();

        $reporte->orden_trabajo_id = $ordene->id;
        $reporte->tecnico_id = auth()->id();
        $reporte->fecha_inicio = $ordene->fecha_inicio;
        $reporte->fecha_fin = now();
        $reporte->diagnostico = $request->diagnostico;
        $reporte->solucion = $request->solucion;
        $reporte->materiales = $request->materiales;
        $reporte->observaciones = $request->observaciones;
        $reporte->costo = $request->costo;

        

                // Cambiar estado de la orden
                $ordene->update([

                    'estado' => 'Esperando validación',

                ]);

        // Aquí después guardaremos las evidencias

        return redirect()
            ->route('ordenes.show', $ordene)
            ->with('success', 'El reporte fue enviado para validación.');
    }
}

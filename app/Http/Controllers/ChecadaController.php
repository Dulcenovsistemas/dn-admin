<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChecadasImport;
use App\Exports\ChecadasExport;

use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ChecadaController extends Controller
{
    public function index()
    {
        return view('checadas.index');
    }

    public function importar(Request $request)
    {
        $archivo = $request->file('archivo');

        $spreadsheet = IOFactory::load($archivo->getRealPath());

        $sheet = $spreadsheet->getSheetByName('Reporte de Asistencia');

        $rows = $sheet->toArray();

        $dias = $rows[3];

        $resultado = [
            [
                'ID',
                'NOMBRE',
                'FECHA',
                'ENTRADA',
                'SALIDA',
                'HRS',
                'HRS EXT',
                'OBSERVACIONES'
            ]
        ];

        // Fecha inicial del periodo
        $fechaActual = Carbon::parse('2026-05-27');

        foreach ($dias as $columna => $diaNumero) {

            $fechas[$columna] = $fechaActual->copy();

            $fechaActual->addDay();
        }

        for ($i = 4; $i < count($rows); $i += 2) {

            $empleado = $rows[$i];
            $checadas = $rows[$i + 1] ?? [];

            $id = $empleado[2] ?? null;
            $nombre = trim($empleado[10] ?? '');

            if (!$id || !$nombre) {
                continue;
            }

            foreach ($dias as $columna => $dia) {

                $valor = $checadas[$columna] ?? null;

                if (empty($valor)) {
                    continue;
                }

                // Ejemplo: 08:0017:14
                if (strlen($valor) < 10) {
                    continue;
                }

                $entrada = substr($valor, 0, 5);
                $salida  = substr($valor, 5, 5);

                $entradaCarbon = Carbon::createFromFormat('H:i', $entrada);
                $salidaCarbon  = Carbon::createFromFormat('H:i', $salida);

                $minutos = $entradaCarbon->diffInMinutes($salidaCarbon);

                $hrs = round($minutos / 60, 2);

                $hrsExt = round($hrs - 8, 2);

                $resultado[] = [
                        $id,
                        $nombre,
                        $fechas[$columna]->format('d/m/Y'),
                        $entrada,
                        $salida,
                        $hrs,
                        $hrsExt,
                        ''
                    ];
            }
        }

        return Excel::download(
            new ChecadasExport($resultado),
            '02_CHECADAS.xlsx'
        );
    }
}
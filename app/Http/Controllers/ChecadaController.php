<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class ChecadaController extends Controller
{
    public function index()
    {
        return view('checadas.index');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xls,xlsx',
        ]);

        $archivo = $request->file('archivo');

        // Carpeta temporal para los archivos del proceso
        $carpeta = storage_path('app/temp');

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // Archivo de entrada
        $entrada = $archivo->getRealPath();

        // Archivo de salida
        $salida = $carpeta . DIRECTORY_SEPARATOR . 'Control_Asistencia_RH.xlsx';

        // Ejecutar Python
        $python = base_path('python/.venv/Scripts/python.exe');
        $script = base_path('python/generar_reporte.py');

        $process = new Process([
            $python,
            $script,
            $entrada,
            $salida,
        ]);

        $process->setTimeout(120);
        $process->run();

        // Si Python encontró un error
        if (!$process->isSuccessful()) {

            return back()->with(
                'error',
                'No se pudo generar el reporte: ' . $process->getErrorOutput()
            );
        }

        // Verificar que realmente se creó el Excel
        if (!file_exists($salida)) {

            return back()->with(
                'error',
                'Python terminó correctamente, pero no se encontró el archivo generado.'
            );
        }

        // Descargar el reporte
        return response()
            ->download(
                $salida,
                'Control_Asistencia_RH.xlsx'
            )
            ->deleteFileAfterSend(true);
    }
}
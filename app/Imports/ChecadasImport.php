<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ChecadasImport implements ToCollection
{
    public array $resultado = [];

    public function collection(Collection $rows)
    {
        $this->resultado[] = [
            'ID Empleado',
            'Nombre',
            'Fecha',
            'Entrada',
            'Salida',
            'Horas',
            'Horas Extra',
            'Observaciones'
        ];

        $fechaInicio = \Carbon\Carbon::parse('2026-05-27');

        foreach ($rows as $index => $row) {

            if ($index < 4) {
                continue;
            }

            $empleadoId = $row[0] ?? null;
            $nombre = $row[1] ?? null;

            if (!$empleadoId || !$nombre) {
                continue;
            }

            for ($col = 3; $col <= 11; $col++) {

                if (empty($row[$col])) {
                    continue;
                }

                $fecha = $fechaInicio->copy()->addDays($col - 3);

                $this->resultado[] = [
                    $empleadoId,
                    $nombre,
                    $fecha->format('Y-m-d'),
                    '',
                    '',
                    '',
                    '',
                    ''
                ];
            }
        }
    }
}
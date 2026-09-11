<?php

namespace App\Exports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquiposExport implements FromCollection, WithHeadings
{
    protected $areaId;

    public function __construct($areaId)
    {
        $this->areaId = $areaId;
    }

    public function collection()
    {
        return Equipo::with(['sucursal', 'area'])
            ->where('area_id', $this->areaId)
            ->get()
            ->map(function ($equipo) {

                return [
                    $equipo->id,
                    $equipo->sucursal?->name,
                    $equipo->area?->name,
                    $equipo->nombre,
                    $equipo->marca_modelo,
                    $equipo->numero_serie,
                    $equipo->responsable,
                    $equipo->fecha_adquisicion,
                    $equipo->especificaciones,
                ];

            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Sucursal',
            'Área',
            'Equipo',
            'Marca / Modelo',
            'Número de serie',
            'Responsable',
            'Fecha de adquisición',
            'Especificaciones',
        ];
    }
}
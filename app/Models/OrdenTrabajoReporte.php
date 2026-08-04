<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoReporte extends Model
{

    protected $table = 'ordenes_trabajo_reportes';

    protected $fillable = [

        'orden_trabajo_id',

        'tecnico_id',

        'fecha_inicio',

        'fecha_fin',

        'diagnostico',

        'solucion',

        'materiales',

        'observaciones',

        'costo',

    ];

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class,'tecnico_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajoEvidencia extends Model
{
    protected $table = 'ordenes_trabajo_evidencias';

    protected $fillable = [
        'orden_trabajo_id',
        'archivo',
        'tipo',
        'descripcion',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'orden_trabajo_id');
    }
}
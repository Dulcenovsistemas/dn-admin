<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'sucursal_id',
        'area_id',
        'tipo_servicio',
        'nombre',
        'descripcion',
        'proveedor',
        'numero_contrato',
        'costo_mensual',
        'fecha_inicio',
        'estatus',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Branch::class, 'sucursal_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
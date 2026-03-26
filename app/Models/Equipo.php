<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'sucursal_id',
        'area_id',
        'nombre',
        'marca_modelo',
        'numero_serie',
        'fecha_adquisicion',
        'responsable',
        'especificaciones',
        'qr_codigo'
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
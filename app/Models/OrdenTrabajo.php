<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    protected $table = 'ordenes_trabajo';

    protected $fillable = [
        'folio',
        'branch_id',
        'area_id',
        'user_id',
        'tecnico_id',
        'categoria',
        'equipo_id',
        'servicio_id',
        'tipo_mantenimiento',
        'prioridad',
        'estado',
        'descripcion',
        'solucion',
        'observaciones',
        'costo',
        'fecha_programada',
        'fecha_inicio',
        'fecha_fin',
        'created_by',
        'closed_by',
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_inicio'     => 'datetime',
        'fecha_fin'        => 'datetime',
        'costo'            => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function sucursal()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cerradoPor()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function evidencias()
    {
        return $this->hasMany(OrdenTrabajoEvidencia::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function reporte()
    {
        return $this->hasOne(OrdenTrabajoReporte::class);
    }

}
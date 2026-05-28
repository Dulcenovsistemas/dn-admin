<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'name',
        'branch_id'
    ];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }
}

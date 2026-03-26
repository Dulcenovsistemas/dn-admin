<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'city'];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function jobPositions()
    {
        return $this->belongsToMany(JobPosition::class, 'branch_job_positions');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
   protected $fillable = ['name'];

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_job_positions');
    }
}

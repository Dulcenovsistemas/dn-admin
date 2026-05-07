<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [

        // 🔵 Datos personales
        'name',
        'last_name',
        'second_last_name',
        'birth_date',
        'phone',
        'address',

        // 🟢 Datos laborales
        'position',
        'department',
        'hire_date',
        'status',

        // 🟡 Datos fiscales
        'curp',
        'rfc',
        'imss',
        'clabe',

        // 📸 Foto
        'photo',

        'branch_id',
        'job_position_id'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function files()
    {
        return $this->hasMany(EmployeeFile::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }

}

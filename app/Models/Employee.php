<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [

        'employee_number',

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


    public function vacationMovements()
    {
        return $this->hasMany(VacationMovement::class);
    }

    public function vacationPeriods()
    {
        return $this->hasMany(VacationPeriod::class);
    }

    public function activeVacationPeriod()
    {
        return $this->hasOne(VacationPeriod::class)
            ->where('status', 'open')
            ->latestOfMany('period_start');
    }

}

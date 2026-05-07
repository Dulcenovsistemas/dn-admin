<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeFile extends Model
{
    protected $fillable = [
        'employee_id',
        'file_path',
        'file_name'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
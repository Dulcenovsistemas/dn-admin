<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $fillable = [
        'employee_id',
        'vacation_year',
        'start_date',
        'end_date',
        'available_days',
        'taken_days',
        'balance_days',
        'salary_daily',
        'vacation_pay',
        'prima_vacacional',
        'total_pay',
        'prima_percentage',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacationPeriod extends Model
{
    protected $fillable = [
        'employee_id',
        'period_start',
        'period_end',
        'years_of_service',
        'entitled_days',
        'taken_days',
        'pending_days',
        'status',
        'generated_at'
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

    public function movements()
    {
        return $this->hasMany(VacationMovement::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAvailableDaysAttribute()
    {
        return max(0, $this->entitled_days - $this->taken_days - $this->pending_days);
    }

    /*
    |--------------------------------------------------------------------------
    | Lógica de cálculo
    |--------------------------------------------------------------------------
    */

    public function recalculateDays()
    {
        $this->taken_days = (int) $this->movements()
            ->where('status', 'approved')
            ->whereIn('type', ['taken', 'approved'])
            ->sum('days');

        $this->pending_days = (int) $this->movements()
            ->where('status', 'pending')
            ->where('type', 'request')
            ->sum('days');

        $this->save();

        return $this->refresh();
    }
}
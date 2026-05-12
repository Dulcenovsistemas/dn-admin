<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\VacationPeriod;
use Carbon\Carbon;

class VacationCalculatorService
{
    public function getDaysByYears(int $years): int
    {
        return match (true) {
            $years <= 1  => 12,
            $years == 2  => 14,
            $years == 3  => 16,
            $years == 4  => 18,
            $years == 5  => 20,
            $years >= 6  && $years <= 10 => 22,
            $years >= 11 && $years <= 15 => 24,
            $years >= 16 && $years <= 20 => 26,
            $years >= 21 && $years <= 25 => 28,
            default => 30,
        };
    }

    public function syncEmployeePeriods(Employee $employee): void
    {
        if (! $employee->hire_date) {
            return;
        }

        $hireDate = Carbon::parse($employee->hire_date)->startOfDay();
        $today = now()->startOfDay();

        $periodStart = $hireDate->copy();
        $yearsOfService = 1;

        while ($periodStart->lte($today)) {
            $periodEnd = $periodStart->copy()->addYear()->subDay();

            $isCurrentPeriod = $periodEnd->gte($today);

            $period = VacationPeriod::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'period_start' => $periodStart->toDateString(),
                ],
                [
                    'period_end' => $periodEnd->toDateString(),
                    'years_of_service' => $yearsOfService,
                    'entitled_days' => $this->getDaysByYears($yearsOfService),
                    'taken_days' => 0,
                    'pending_days' => 0,
                    'generated_at' => now()->toDateString(),
                    'status' => $isCurrentPeriod ? 'open' : 'closed',
                ]
            );

            $this->recalculatePeriod($period);

            $periodStart->addYear();
            $yearsOfService++;
        }
    }

    public function recalculatePeriod(VacationPeriod $period): VacationPeriod
    {
        $period->taken_days = (int) $period->movements()
            ->where('status', 'approved')
            ->whereIn('type', ['taken', 'approved'])
            ->sum('days');

        $period->pending_days = (int) $period->movements()
            ->where('status', 'pending')
            ->where('type', 'request')
            ->sum('days');

        $period->save();

        return $period->refresh();
    }
} 

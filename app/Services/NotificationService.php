<?php

namespace App\Services;

use App\Models\Employee;
use Carbon\Carbon;

class NotificationService
{
    public function upcomingBirthdays($days = 7)
    {
        $today = Carbon::today();
        $limit = Carbon::today()->addDays($days);

        return Employee::whereNotNull('birth_date')
            ->get()
            ->filter(function ($employee) use ($today, $limit) {

                $birthday = Carbon::parse($employee->birth_date)
                    ->year($today->year);

                if ($birthday->lt($today)) {
                    $birthday->addYear();
                }

                return $birthday->between($today, $limit);
            });
    }
}
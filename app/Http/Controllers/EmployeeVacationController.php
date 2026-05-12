<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\VacationCalculatorService;

class EmployeeVacationController extends Controller
{
    public function index(VacationCalculatorService $calculator)
    {
        $employees = Employee::orderBy('name')->get();

        foreach ($employees as $employee) {
            $calculator->syncEmployeePeriods($employee);
        }

        $employees = Employee::with('activeVacationPeriod')
            ->orderBy('name')
            ->get();

        return view('modules.rh.vacations.index', compact('employees'));
    }
}
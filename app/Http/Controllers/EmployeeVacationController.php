<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\VacationCalculatorService;
use Illuminate\Http\Request;

class EmployeeVacationController extends Controller
{
    public function index(Request $request, VacationCalculatorService $calculator)
    {
        $employees = Employee::with('activeVacationPeriod')
            ->orderBy('name')
            ->get();

        $selectedEmployee = $request->filled('employee_id')
            ? Employee::find($request->employee_id)
            : null;

        $result = null;

        if ($selectedEmployee && $request->filled('current_date')) {
            $result = $calculator->calculatePreview(
                $selectedEmployee,
                $request->current_date,
                (int) $request->input('taken_days', 0)
            );
        }

        return view('modules.rh.vacations.index', compact(
            'employees',
            'selectedEmployee',
            'result'
        ));
    }

    public function calculate(Request $request, VacationCalculatorService $calculator)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'current_date' => 'required|date',
            'taken_days' => 'nullable|integer|min:0',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $result = $calculator->calculatePreview(
            $employee,
            $request->current_date,
            $request->taken_days ?? 0
        );

        $employees = Employee::with('activeVacationPeriod')
            ->orderBy('name')
            ->get();

        return view('modules.rh.vacations.index', compact('employees', 'result', 'employee'));
    }
}
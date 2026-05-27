<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\VacationCalculatorService;
use Illuminate\Http\Request;

use App\Models\Vacation;
use Carbon\Carbon;

class EmployeeVacationController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));

        $employees = Employee::with('activeVacationPeriod')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('employee_number', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('modules.rh.vacations.index', compact('employees', 'search'));
    }

    public function create(Employee $employee)
    {
        return view('modules.rh.vacations.calculator', compact('employee'));
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

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'available_days' => 'required|integer|min:0',
            'salary_daily' => 'required|numeric|min:0',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $takenDays = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;

        $availableDays = (int) $request->available_days;
        $balanceDays = $availableDays - $takenDays;

        $salaryDaily = (float) $request->salary_daily;
        $vacationPay = $salaryDaily * $takenDays;
        $primaVacacional = $vacationPay * 0.25;
        $totalPay = $vacationPay + $primaVacacional;

        $vacation = Vacation::create([
            'employee_id' => $employee->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'available_days' => $availableDays,
            'taken_days' => $takenDays,
            'balance_days' => $balanceDays,
            'salary_daily' => $salaryDaily,
            'vacation_pay' => $vacationPay,
            'prima_vacacional' => $primaVacacional,
            'total_pay' => $totalPay,
            'prima_percentage' => 25,
        ]);

        return redirect()->route('vacations.receipt', $vacation->id);
        }

    public function receipt(Vacation $vacation)
    {
            $vacation->load('employee');

            return view('modules.rh.vacations.receipt', compact('vacation'));
    }

    public function periods(Employee $employee)
    {
        $periods = Vacation::where('employee_id', $employee->id)
            ->orderByDesc('start_date')
            ->get();

        return view('modules.rh.vacations.periods', compact('employee', 'periods'));
    }
    
}
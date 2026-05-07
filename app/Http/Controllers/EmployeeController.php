<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeFile;

use App\Models\Branch;
use App\Models\JobPosition;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::latest()->get();

        return view('modules.rh.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
   
    public function create()
    {
        $branches = Branch::all();

        $jobPositions = JobPosition::all();

        return view('modules.rh.employees.create', compact(
            'branches',
            'jobPositions'
        ));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([

            'employee_number' => 'nullable|unique:employees,employee_number',

            // 🔵 Datos personales
            'name' => 'required',
            'last_name' => 'nullable',
            'second_last_name' => 'nullable',

            'birth_date' => 'nullable|date',

            'phone' => 'nullable',
            'address' => 'nullable',

            // 🟢 Datos laborales
            'position' => 'nullable',
            'department' => 'nullable',
            'branch_id' => 'nullable|exists:branches,id',
            'job_position_id' => 'nullable|exists:job_positions,id',

            'hire_date' => 'nullable|date',

            // 🟡 Datos fiscales
            'curp' => 'nullable',
            'rfc' => 'nullable',
            'imss' => 'nullable',
            'clabe' => 'nullable',

            // 📸 Foto
            'photo' => 'nullable|image',

            // 📁 Archivos
            'files.*' => 'nullable|file'

        ]);

        /*
        |--------------------------------------------------------------------------
        | FOTO
        |--------------------------------------------------------------------------
        */

        $photoPath = null;

        if ($request->hasFile('photo')) {

            $photoPath = $request->file('photo')
                ->store('employees/photos', 'public');

        }

        /*
        |--------------------------------------------------------------------------
        | CREAR EMPLEADO
        |--------------------------------------------------------------------------
        */

        $employee = Employee::create([

            'employee_number' => strtoupper($request->employee_number),

            'name' =>strtoupper($request->name),
            'last_name' =>strtoupper($request->last_name),
            'second_last_name' =>strtoupper($request->second_last_name),

            'birth_date' => $request->birth_date,

            'phone' => $request->phone,
            'address' => $request->address,

            'position' => $request->position,
            'department' =>strtoupper($request->department),
            'branch_id' => $request->branch_id,
            'job_position_id' => $request->job_position_id,

            'hire_date' => $request->hire_date,

            'status' => 'active',

            'curp' =>strtoupper($request->curp),
            'rfc' =>strtoupper($request->rfc),
            'imss' =>strtoupper($request->imss),
            'clabe' =>strtoupper($request->clabe),

            'photo' => $photoPath

        ]);

        /*
        |--------------------------------------------------------------------------
        | ARCHIVOS
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $file) {

                $path = $file->store('employees/files', 'public');

                EmployeeFile::create([
                    'employee_id' => $employee->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName()
                ]);

            }

        }

        return redirect()->route('employees.index')
            ->with('success', 'Empleado registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load([
            'branch',
            'jobPosition',
            'files'
        ]);

        return view(
            'modules.rh.employees.show',
            compact('employee')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $branches = Branch::with('jobPositions')->get();

        return view(
            'modules.rh.employees.edit',
            compact('employee', 'branches')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([

            'employee_number' => 'nullable|unique:employees,employee_number',

            'name' => 'required',

            'branch_id' => 'nullable|exists:branches,id',

            'job_position_id' => 'nullable|exists:job_positions,id'

        ]);

        $photoPath = $employee->photo;

        // 📸 Nueva foto
        if ($request->hasFile('photo')) {

            $photoPath = $request->file('photo')
                ->store('employees/photos', 'public');

        }

        $employee->update([

            'employee_number' => strtoupper($request->employee_number),

            'name' => mb_strtoupper($request->name),

            'last_name' => mb_strtoupper($request->last_name),

            'second_last_name' => mb_strtoupper($request->second_last_name),

            'birth_date' => $request->birth_date,

            'phone' => $request->phone,

            'address' => mb_strtoupper($request->address),

            'branch_id' => $request->branch_id,

            'job_position_id' => $request->job_position_id,

            'department' => mb_strtoupper($request->department),

            'hire_date' => $request->hire_date,

            'curp' => mb_strtoupper($request->curp),

            'rfc' => mb_strtoupper($request->rfc),

            'imss' => $request->imss,

            'clabe' => $request->clabe,

            'photo' => $photoPath

        ]);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado actualizado');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado eliminado');
    }
}

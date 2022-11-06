<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Practice;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.employee.index', [
            'employees' => Employee::latest()
                ->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.employee.create', ['practices' => Practice::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newEmployeeForm = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'practice_id' => 'required',
            'email' => ['required', 'email'],
            'phone' => 'nullable'
        ]);

        Employee::create($newEmployeeForm);

        return redirect('/dashboard/employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('dashboard.employee.show', [
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('dashboard.employee.edit', [
            'employee' => $employee,
            'practices' => Practice::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $editEmployeeForm = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'practice_id' => 'required',
            'email' => ['required', 'email'],
            'phone' => 'nullable'
        ]);

        $employee->update($editEmployeeForm);

        return redirect()->route('soleemployee', ['employee' => $employee->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('/dashboard/employees');
    }

    public function destroymultiple(Request $request)
    {
        $idArray = $request->employee;

        $employees = Employee::latest();
        
        $employees->whereIn('id', $idArray)->delete();

        return redirect('/dashboard/employees');
    }
}

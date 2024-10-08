<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{

    const PATH_VIEW = 'employees.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::latest('id')->paginate(10);

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'      => 'required|max:255',
            'last_name'       => 'required|max:255',
            'email'           => 'required|email|max:255',  
            'phone'           => ['required', 'string', 'max:20', Rule::unique('employees')],  
            'date_of_birth'   => 'required|date',  
            'hire_date'       => 'required|date',  
            'salary'          => 'required|numeric|min:0',  
            'is_active'       => ['required', Rule::in([0, 1])], 
            'department_id'   => 'required|exists:departments,id',
            'manager_id'      => 'required|exists:managers,id',
            'address'         => 'required|max:255',
            'profile_picture' => 'nullable|image|max:4096',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = Storage::put('employees', $request->file('profile_picture'));
            }

            Employee::query()->create($data);

            return redirect()
                ->route('employees.index')
                ->with('success', true);

        } catch (\Throwable $th) {
            //throw $th;

            if (!empty($data['profile_picture']) && Storage::exists($data['profile_picture'])) {
                Storage::delete($data['profile_picture']);
            }

            return back()
                ->with('success', true)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee) {
        return view(self::PATH_VIEW . __FUNCTION__, compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee) {
        return view(self::PATH_VIEW . __FUNCTION__, compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee) {
        $data = $request->validate([
            'first_name'      => 'required|max:255',
            'last_name'       => 'required|max:255',
            'email'           => 'required|email|max:255',  
            'phone'           => ['required', 'string', 'max:20', Rule::unique('employees')->ignore($employee->id)],  
            'date_of_birth'   => 'required|date',  
            'hire_date'       => 'required|date',  
            'salary'          => 'required|numeric|min:0',  
            'is_active'       => ['required', Rule::in([0, 1])], 
            'department_id'   => 'required|exists:departments,id',
            'manager_id'      => 'required|exists:managers,id',
            'address'         => 'required|max:255',
            'profile_picture' => 'nullable|image|max:4096',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = Storage::put('employees', $request->file('profile_picture'));
            }

            $currentAvt = $employee->profile_picture;


            $employee->update($data);

            if ($request->hasFile('profile_picture') && !empty($currentAvt) && Storage::exists($currentAvt)) {
                Storage::delete($currentAvt);
            }

            return back()
                ->with('success', true);

        } catch (\Throwable $th) {
            //throw $th;

            if (!empty($data['profile_picture']) && Storage::exists($data['profile_picture'])) {
                Storage::delete($data['profile_picture']);
            }

            return back()
                ->with('success', true)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee) {
        try {
            $employee->delete();
        } catch (\Throwable $th) {
            return back()
                ->with('success', true)
                ->with('error', $th->getMessage());
        }
    }

    public function forceDestroy(Employee $employee) {
        try {
            $employee->forceDelete();

            if (!empty($employee->profile_picture) && Storage::exists($employee->profile_picture)) {
                Storage::delete($employee->profile_picture);
            }

        } catch (\Throwable $th) {
            return back()
                ->with('success', true)
                ->with('error', $th->getMessage());
        }
    }
}

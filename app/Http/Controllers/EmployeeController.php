<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
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
        $data = Employee::withTrashed()->latest('id')->paginate(10);

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $departments = Department::all();


        $managers = collect();

        if ($request->has('department_id') && !empty($request->department_id)) {
            $managers = Manager::where('department_id', $request->department_id)->get();
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('departments', 'managers'));
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
            'is_active'       => ['nullable', Rule::in([0, 1])],
            'department_id'   => 'required|exists:departments,id',
            'manager_id'      => 'required|exists:managers,id',
            'address'         => 'required|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {

                $data['profile_picture'] = file_get_contents($request->file('profile_picture')->getRealPath());
            }

            Employee::query()->create($data);

            return redirect()
                ->route('employees.index')
                ->with('success', true);
        } catch (\Throwable $th) {
            //throw $th;


            return back()
                ->with('success', true)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {

        return view(self::PATH_VIEW . __FUNCTION__, compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee, Request $request)
    {
        $departments = Department::all();

        // Lấy department_id từ request hoặc từ nhân viên hiện tại (nếu chưa chọn phòng ban)
        $selectedDepartmentId = $request->input('department_id', $employee->department_id);

        // Lấy danh sách quản lý dựa trên phòng ban đã chọn (hoặc từ nhân viên hiện tại)
        $managers = Manager::where('department_id', $selectedDepartmentId)->get();


        return view(self::PATH_VIEW . __FUNCTION__, compact('departments', 'selectedDepartmentId', 'managers', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name'      => 'required|max:255',
            'last_name'       => 'required|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => ['required', 'string', 'max:20', Rule::unique('employees')->ignore($employee->id)],
            'salary'          => 'required|numeric|min:0',
            'is_active'       => ['nullable', Rule::in([0, 1])],
            'department_id'   => 'required|exists:departments,id',
            'manager_id'      => 'required|exists:managers,id',
            'address'         => 'required|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {

                $data['profile_picture'] = file_get_contents($request->file('profile_picture')->getRealPath());
            }

            $employee->update($data);

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
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return back()->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function forceDestroy(Employee $employee)
    {
        try {
            $employee->forceDelete();

            if (!empty($employee->profile_picture) && Storage::exists($employee->profile_picture)) {
                Storage::delete($employee->profile_picture);
            }

            return redirect()->route('employees.index')->with('success', true);
        } catch (\Throwable $th) {
            return redirect()->route('employees.index')
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function restore(Employee $employee)
    {
        $employee->restore();
        return redirect()->route('employees.index')->with('success', true);
    }
}

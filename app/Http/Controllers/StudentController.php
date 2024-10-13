<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Passport;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('passport', 'classroom', 'subjects')->latest()->paginate(5);
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        return view('students.index', compact('students', 'classrooms', 'subjects'));
    }

    public function create()
    {

        $classrooms = Classroom::all();
        $subjects = Subject::all();

        return view('students.create', compact('classrooms', 'subjects'));
    }

    public function store(Request $request)
    {
        // Validate data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'classroom_id' => 'required|exists:classrooms,id',
            'passport_number' => 'required|string|max:50',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
        ]);

        try {
            DB::beginTransaction(); // Bắt đầu quá trình đẩy dữ liệu

            // Tạo sinh viên mới
            $student = Student::create($data);

            // Tạo hộ chiếu với thông tin bắt buộc
            Passport::create([
                'student_id' => $student->id,
                'passport_number' => $request->passport_number,
                'issued_date' => $request->issue_date,
                'expiry_date' => $request->expiry_date,
            ]);

            DB::commit(); // Cam kết quá trình đẩy dữ liệu

            return redirect()
            ->route('students.index')
            ->with('success', true);

        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function show(Student $student)
    {

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {

        $classrooms = Classroom::all();
        $subjects = Subject::all();
        return view('students.edit', compact('student', 'classrooms', 'subjects'));
    }

    public function update(Request $request, Student $student)
    {
        // Validate data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'classroom_id' => 'required|exists:classrooms,id',
            'passport_number' => 'required|string|max:50|unique:passports,passport_number,' . $student->passport->id,
        ]);

        try {
            DB::beginTransaction(); // Bắt đầu quá trình đẩy dữ liệu

            // Cập nhật sinh viên
            $student->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'classroom_id' => $data['classroom_id'],
            ]);

            // Cập nhật hộ chiếu
            $student->passport()->update([
                'passport_number' => $data['passport_number'],
            ]);

            DB::commit(); // Cam kết quá trình đẩy dữ liệu
            return back()
            ->with('success', true);
        } catch (\Throwable $th) {
            return back()
            ->with('success', false)
            ->with('error', $th->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return back()->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function search(Request $request)
    {
        Log::info('Searching for students:', $request->all());
        $query = Student::with('classroom'); // Khai báo mối quan hệ lớp học nếu cần

        // Tìm kiếm theo tên sinh viên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Tìm kiếm theo classroom_id
        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        // Lấy danh sách sinh viên theo điều kiện đã lọc
        $students = $query->paginate(5);
        if ($students->isEmpty()) {
            return redirect()->back()->with('message', 'Không tìm thấy sinh viên nào.');
        }

        // Lấy danh sách lớp học để hiển thị trong view
        $classrooms = Classroom::all();

        return view('students.index', compact('students', 'classrooms'));
    }
}

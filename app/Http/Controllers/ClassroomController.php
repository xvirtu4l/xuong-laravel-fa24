<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $data = Classroom::latest()->paginate(5);
        return view('classrooms.index', compact('data'));
    }

    public function create()
    {   

        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        // Validate data
        $data = $request->validate([
            'name' => 'required',
            'teacher_name' => 'required',
        ]);

        try {
            Classroom::create($data);
            return redirect()->route('classrooms.index')->with('success', 'Classroom created successfully.');
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function show(Classroom $classroom)
    {
        try {

            return view('classrooms.show', compact('classroom'));
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error',);
        }
    }

    public function edit(Classroom $classroom)
    {
        try {
            return view('classrooms.edit', compact('classroom'));
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, Classroom $classroom)
    {
        // Validate data
        $data = $request->validate([
            'name' => 'required',
            'teacher_name' => 'required',
        ]);

        try {
            $classroom->update($data);
            return redirect()->route('classrooms.index')->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function destroy(Classroom $classroom)
    {
        try {
            $classroom->delete();
            return redirect()->route('classrooms.index')->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {

        $data = Subject::latest()->paginate(5);
        return view('subjects.index', compact('data'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        // Validate data
        $data = $request->validate([
            'name' => 'required',
            'credits' => 'required|integer',
        ]);

        try {
            Subject::create($data);
            return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function show(Subject $subject)
    {
        try {
            return view('subjects.show', compact('subject'));
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function edit(Subject $subject)
    {
        try {
            return view('subjects.edit', compact('subject'));
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, Subject $subject)
    {
        // Validate data
        $data = $request->validate([
            'name' => 'required',
            'credits' => 'required|integer',
        ]);

        try {
            $subject->update($data);
            return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }
}

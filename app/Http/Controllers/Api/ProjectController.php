<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return response()->json([
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
        ]);

        $project = Project::create($validatedData);

        return response()->json([
            'message' => 'Dự án được tạo thành công',
            'project' => $project,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
        ]);

        $project->update($validatedData);

        return response()->json([
            'message' => 'Dự án được cập nhật',
            'project' => $project,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $project->delete();

        return response()->json(['message' => 'Dự án được xóa']);
    }
}

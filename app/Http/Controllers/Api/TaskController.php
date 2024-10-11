<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $tasks = $project->tasks;

        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Chưa bắt đầu,Đang thực hiện,Đã hoàn thành',
        ]);

        $task = $project->tasks()->create($validatedData);

        return response()->json([
            'message' => 'Nhiệm vụ được tạo',
            'task' => $task,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, $projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $task = $project->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Nhiệm vụ không tồn tại'], 404);
        }

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, $projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $task = $project->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Nhiệm vụ không tồn tại'], 404);
        }

        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Chưa bắt đầu,Đang thực hiện,Đã hoàn thành',
        ]);

        $task->update($validatedData);

        return response()->json([
            'message' => 'Nhiệm vụ được cập nhật',
            'task' => $task,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, $projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại'], 404);
        }

        $task = $project->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Nhiệm vụ không tồn tại'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Nhiệm vụ được xóa']);
    }
}

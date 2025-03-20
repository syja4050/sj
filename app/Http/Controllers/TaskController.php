<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        Task::create([
            'task' => $request->task,
            'description' => $request->description
        ]);

        return redirect()->route('index');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        // Check if it's a toggle request or an edit request
        if ($request->has('toggle_completed')) {
            // Toggle is_completed status
            $task->is_completed = !$task->is_completed;
        } else {
            // Validate input if editing task details
            $request->validate([
                'task' => 'required|string|max:255',
                'description' => 'nullable|string|max:500'
            ]);
    
            // Update task name and description
            $task->task = $request->task;
            $task->description = $request->description;
        }
    
        // Save changes
        $task->save();
    
        Log::info("Task ID {$task->id} updated: is_completed = {$task->is_completed}, task = {$task->task}");
    
        return redirect()->route('index');
    }
    
    

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('index');
    }
}

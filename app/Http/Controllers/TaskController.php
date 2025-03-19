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

    public function update(Task $task)
    {
        $task->is_completed = !$task->is_completed;
        $task->save();
    
        Log::info("Task ID {$task->id} updated: is_completed = {$task->is_completed}");
    
        return redirect()->route('index');
    }
    

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('index');
    }
}

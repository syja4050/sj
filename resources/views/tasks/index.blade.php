<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .completed {
        text-decoration: line-through;
        color: gray; /* Optional: make it visually distinct */
    }
    </style>

</head>
<body>
    <div class="container mt-5">
        <h1>To-Do List</h1>

        <!-- Add Task Form -->
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="task" class="form-control" placeholder="Enter a task" required>
            </div>
            <div class="mb-3">
                <textarea name="description" class="form-control" placeholder="Enter task description" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Add Task</button>
        </form>

        <!-- Task List -->
        <ul class="list-group mt-4">
    @foreach ($tasks as $task)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <!-- Apply 'completed' class dynamically -->
                <strong class="{{ $task->is_completed ? 'completed' : '' }}">
                    {{ $task->task }}
                </strong>
                <p class="mb-0 text-muted {{ $task->is_completed ? 'completed' : '' }}">
                    {{ $task->description }}
                </p>
            </div>

            <div>
                <!-- Mark as Complete/Undo -->
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" style="display:inline;">
                    @method('PUT')
                    @csrf
                    <button class="btn btn-success btn-sm" type="submit">
                        {{ $task->is_completed ? 'Undo' : 'Complete' }}
                    </button>
                </form>

                <!-- Edit Task -->
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <!-- Delete Task -->
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
            </div>
        </li>
    @endforeach
</ul>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

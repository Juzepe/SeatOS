<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tasks\CreateTaskRequest;
use App\Http\Requests\Api\Tasks\EditTaskRequest;
use App\Http\Resources\Tasks\TaskResource;
use App\Models\Task;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::callback('status', function ($query, $value) {
                    $query->where('status', "{$value}");
                }),
                AllowedFilter::callback('due_date', function ($query, $value) {
                    $query->where('due_date', "{$value}");
                }),
                AllowedFilter::callback('from_due_date', function ($query, $value) {
                    $query->where('due_date', '>=', "{$value}");
                }),
                AllowedFilter::callback('to_due_date', function ($query, $value) {
                    $query->where('due_date', '<=', "{$value}");
                }),
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('title', 'ilike', "%{$value}%")
                            ->orWhere('description', 'ilike', "%{$value}%");
                    });
                }),
            ])
            ->paginate(10);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        $task = Task::create(
            array_merge(
                $request->validated(),
                ['creator_id' => auth()->id()],
            )
        );

        return response()->json([
            'message' => 'Task created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return [
            'message' => 'Task updated successfully.',
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully.',
        ]);
    }
}

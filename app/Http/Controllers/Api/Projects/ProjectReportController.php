<?php

namespace App\Http\Controllers\Api\Projects;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectReportController extends Controller
{
    public function index()
    {
        $projects = Project::with('tasks')->get();

        $report = $projects->map(function ($project) {
            $numberOfTasks = $project->tasks->count();
            $numberOfCompletedTasks = $project->tasks()->where('status', TaskStatus::COMPLETED)->count();

            return [
                'title' => $project->title,
                'number_of_tasks' => $numberOfTasks,
                'percentage_of_completed_tasks' => round($numberOfCompletedTasks / $numberOfTasks * 100, 2),
            ];
        });

        return response()->json($report);
    }
}

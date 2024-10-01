<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Notifications\OverDueTaskNotification;
use Illuminate\Console\Command;

class OverDueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:over-due-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for over due tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('due_date', '=', now()->subDay())
            ->where('status', '!=', TaskStatus::COMPLETED)
            ->with('creator')
            ->get();

        foreach ($tasks as $task) {
            $task->creator->notify(new OverDueTaskNotification($task));
        }
    }
}

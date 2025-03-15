<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class CheckExpiredTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark expired task ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        // Find all tasks that are pending and have a due_date in the past
        $tasks = Task::where('status', 'pending')
                    ->where('due_date', '<', $now)
                    ->get();

        foreach ($tasks as $task) {
            // Update the status of the task to expired
            $task->status = 'expired';
            $task->save();

            // Output the result to the console
            $this->info("Task #{$task->id} marked as expired.");
        }

        // If no tasks found, you can print a message (optional)
        if ($tasks->isEmpty()) {
            $this->info('No expired tasks found.');
        }
        //
    }
}

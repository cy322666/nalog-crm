<?php

namespace App\Jobs\Shop;

use App\Models\Shop\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TaskCheckStarting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Task $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__METHOD__.' : задача № '.$this->task->task_id);

        //TODO notification add
    }
}

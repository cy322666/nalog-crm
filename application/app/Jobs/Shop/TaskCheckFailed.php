<?php

namespace App\Jobs\Shop;

use App\Events\Shop\Push\Task\TaskFailedPush;
use App\Models\Shop\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Проверка задачи на факт просрочки
 */
class TaskCheckFailed implements ShouldQueue
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

        if ($this->task->is_execute === false &&
            $this->task->execute_to < Carbon::now()) {

            Log::alert(__METHOD__.' : задача № '.$this->task->task_id.' просрочена');

            $this->task->is_failed = true;
            $this->task->count_failed++;
            $this->task->save();

//            (new TaskFailedPush($this->task))->dispatch();
        }
    }
}

<?php

namespace App\Observers\Shop;

use App\Events\Shop\EntityEvent;
use App\Jobs\Shop\TaskCheckFailed;
use App\Jobs\Shop\TaskCheckStarting;
use App\Models\Shop\Task;
use App\Models\User;
use App\Services\Event\EventManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param Task $task
     * @return void
     */
    public function created(Task $task)
    {
        event(new EntityEvent(
            User::query()->find($task->creator_id)->first(),
            $task,
            EventManager::taskCreated(),
        ));

        $secToFail  = Carbon::parse($task->execute_to)->diff(Carbon::now())->s;
        $secToStart = Carbon::parse($task->execute_at)->diff(Carbon::now())->s;

        Log::info(__METHOD__.' : '.$secToStart.' секунд до старта '.$task->task_id);
        Log::info(__METHOD__.' : '.$secToFail.' секунд до выполнения '.$task->task_id);

        if ($secToStart > 0) {

            TaskCheckStarting::dispatch($task)->delay($secToStart);
        }
        TaskCheckFailed::dispatch($task)->delay($secToFail);
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param Task $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param Task $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param Task $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}

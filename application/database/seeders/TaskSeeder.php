<?php

namespace Database\Seeders;

use App\Models\Shop\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = Task::factory()->count(2000)->create();

        $latest = Task::query()->latest()->first();

        $taskId = $latest && $latest->task_id !== null ? $latest->task_id++ : 1;

        foreach ($tasks as $task) {

            $shop = $task->shop;

            $task->is_execute = rand(true, false);

            if ($task->is_execute == true) {

                $task->execute_comment = 'ok';
            }

            if ($task->is_execute == false && rand(0,1) == 1) {

                $task->is_failed = true;
            }

            if ($task->model_type == 1) {

                $task->model_id = $shop->orders->random()->id;
            } else {

                $task->model_id = $shop->customers->random()->id;
            }

            $task->execute_to = Carbon::parse($task->execute_at)->addDay()->format('Y-m-d H:i:s');

            if ($task->is_failed == true) {

                $task->count_failed = 1;
                $task->failed_at = Carbon::parse($task->execute_to)->subHour()->format('Y-m-d H:i:s');
            }

            $task->task_id = $taskId;
            $task->creator_id = $shop->users->random()->id;
            $task->responsible_id = $shop->users->random()->id;
            $task->save();

            $taskId++;
        }
    }
}

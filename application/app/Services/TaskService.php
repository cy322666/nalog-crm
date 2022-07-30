<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TaskService
{
    public string $label; //заголовок
    public string $text = '';  //текст задачи
    public string $color; //цвет
    public string $state = self::EMPTY_STATE; //состояние

    public const TOMORROW_COLOR = 'gray';
    public const TOMORROW_LABEL = 'Задача на завтра!';
    public const TOMORROW_STATE = 'tomorrow';

    public const TODAY_COLOR = 'lime';
    public const TODAY_LABEL = 'Задача на сегодня!';
    public const TODAY_STATE = 'today';

    public const LATER_COLOR = 'primary';
    public const LATER_LABEL = 'Выполнить позже';
    public const LATER_STATE = 'later';

    public const FAIL_COLOR  = 'red';
    public const FAIL_LABEL  = 'Задача просрочена!';
    public const FAIL_STATE  = 'fail';

    public const EMPTY_COLOR = 'orange';
    public const EMPTY_LABEL = 'Нет задачи!';
    public const EMPTY_STATE = 'empty';

    public function __construct(private ?Model $model = null)
    {
        if ($this->model == null) {

            return;
        }

        $task = $this->model->tasks()
            ->where('is_execute', false)
            ->latest('execute_to')
            ->first();

        if ($task) {

            $this->text = $task->title;

            if (Carbon::parse($task->execute_to)->diffInDays(Carbon::now()) == 0) {

                $this->state = self::TODAY_STATE;

            } elseif (Carbon::parse($task->execute_to)->diffInDays(Carbon::now()->addDay()) == 0) {

                $this->state = self::TOMORROW_STATE;

            } elseif (Carbon::parse($task->execute_to) < Carbon::now()) {

                $this->state = self::FAIL_STATE;

            } else
                $this->state = self::LATER_STATE;
        } else
            $this->state = self::EMPTY_STATE;

        $this->init();
    }

    private function init()
    {
        switch($this->state) {

            case self::LATER_STATE :
                $this->label = self::LATER_LABEL;
                $this->color = self::LATER_COLOR;
                break;
            case self::TOMORROW_STATE :
                $this->label = self::TOMORROW_LABEL;
                $this->color = self::TOMORROW_COLOR;
                break;
            case self::TODAY_STATE :
                $this->label = self::TODAY_LABEL;
                $this->color = self::TODAY_COLOR;
                break;
            case self::FAIL_STATE :
                $this->label = self::FAIL_LABEL;
                $this->color = self::FAIL_COLOR;
                break;

            case self::EMPTY_STATE :
            default:
                $this->label = self::EMPTY_LABEL;
                $this->color = self::EMPTY_COLOR;
        };
    }
}

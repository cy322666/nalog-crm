<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use InvadersXX\FilamentKanbanBoard\FilamentKanbanBoard;

class KanbanTask extends FilamentKanbanBoard
{
    protected static string $resource = TaskResource::class;

    public bool $sortable = false;
    public bool $sortableBetweenStatuses = true;
    public bool $recordClickEnabled = true;

    private const FAILED_STATUS_ID = 0;
    private const FAILED_STATUS_TITLE = 'Просрочены';
    private const FAILED_STATUS_COLOR = 'bg-danger-500/10';

    private const TODAY_STATUS_ID = 1;
    private const TODAY_STATUS_TITLE = 'Выполнить сегодня';
    private const TODAY_STATUS_COLOR = 'bg-success-500/10';

    private const LATER_STATUS_ID = 2;
    private const LATER_STATUS_TITLE = 'Выполнить позже';
    private const LATER_STATUS_COLOR = 'bg-gray-500/10';

    private static array $statuses = [
        [
            'id'    => self::FAILED_STATUS_ID,
            'title' => self::FAILED_STATUS_TITLE,
            'color' => self::FAILED_STATUS_COLOR,
        ],
        [
            'id'    => self::TODAY_STATUS_ID,
            'title' => self::TODAY_STATUS_TITLE,
            'color' => self::TODAY_STATUS_COLOR,
        ],
        [
            'id'    => self::LATER_STATUS_ID,
            'title' => self::LATER_STATUS_TITLE,
            'color' => self::LATER_STATUS_COLOR,
        ]
    ];

    protected function getTitle(): string
    {
        return 'Канбан';
    }

    protected function statuses() : Collection
    {
        return collect(self::$statuses);
    }

    protected function styles(): array
    {
        return [
            'wrapper'       => 'w-full h-full flex space-x-4 overflow-x-auto',
            'kanbanWrapper' => 'h-full flex-1',
            'kanban'        => 'rounded-md px-1 flex space-y-2 flex-col h-full mt-4',
            'kanbanHeader'  => 'border rounded p-4 text-md text-center text-gray-900',//border-l-primary-500
            'kanbanFooter'  => '',
            'kanbanRecords' => 'space-y-2 p-2 flex-1 overflow-y-auto',
            'record'        => 'shadow relative p-4 rounded-md bg-white filament-stats-card dark:bg-gray-800',
            'recordContent' => 'w-full',
        ];
    }

    protected function records() : Collection
    {
        return Task::all()
            ->where('responsible_id', Auth::user()->id)
            ->where('is_execute', false)
            ->map(function (Task $task) {
                return [
                    'id'     => $task->task_id,
                    'label'  => $task->label(),
                    'title'  => $task->title,
                    'link'   => $task->link(),
                    'text'      => $task->text,
                    'executeTo' => $task->execute_to,
                    'responsible' => $task->responsibleName(),
                    'status'    => self::getStatusId($task),
                ];
            });
    }

    private static function getStatusId (Task $task)
    {
        if ($task->is_failed === true) {

            return self::FAILED_STATUS_ID;

        } elseif (
            Carbon::parse($task->execute_to) == Carbon::now()) {

            return self::TODAY_STATUS_ID;

        } else {

            return self::LATER_STATUS_ID;
        }
    }

    public static function route(string $path): array
    {
        return [
            'class' => static::class,
            'route' => $path,
        ];
    }

//    protected static string $view = 'vendor.filament-kanban-board.kanban-board';
        //'filament.resources.shop.task-resource.pages.kanban-task';
}

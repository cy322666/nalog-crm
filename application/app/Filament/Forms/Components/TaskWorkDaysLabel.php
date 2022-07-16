<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class TaskWorkDaysLabel extends Field
{
    protected string $view = 'forms.components.task-work-days-label';

    public string $info;

    public function getInfo(): string
    {
        return $this->info;
    }
}

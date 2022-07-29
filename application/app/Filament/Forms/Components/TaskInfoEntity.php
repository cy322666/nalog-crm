<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class TaskInfoEntity extends Field
{
    protected string $view = 'forms.components.task-info-entity';

    public static string $viewName = 'forms.components.task-info-entity';

    public string $info;

    public function getInfo(): string
    {
        return $this->info;
    }
}

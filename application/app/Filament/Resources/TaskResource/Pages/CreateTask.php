<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\Shop\TaskResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateTask extends CreateRecord
{
    protected static string $resource = \App\Filament\Resources\TaskResource::class;

    protected function getTitle(): string
    {
        return ''; // TODO: Change the autogenerated stub
    }
}
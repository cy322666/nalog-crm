<?php

namespace App\Filament\Resources\Shop\StatusResource;

use App\Filament\Resources\Shop\StatusResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatuses extends ListRecords
{
    protected static string $resource = StatusResource::class;

    protected ?string $maxContentWidth = '5xl';

    protected function getTitle(): string
    {
        return 'Статусы';
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    public function isTableSearchable(): bool
    {
        return false;
    }
}

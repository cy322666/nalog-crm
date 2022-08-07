<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ListShopsWidget;
use App\Services\CacheService;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

/**
 * Страница для отображения филиалов
 * Если филиал один, то редирект на задачи
 */
class Shops extends Page
{
    public function __construct()//$id = null
    {
        if (Auth::hasUser()) {

            $accounts = Auth::user()
                ->shops()
                ->where('active', true)
                ->get();

            if ($accounts->count() == 1) {

                //TODO logout delete key
                //user_{id}_account
                CacheService::setAccountId($accounts->first()->id);

                $this->redirect(route('filament.resources.tasks.index'));//TODO norm ti cho
            }
        }
        //TODO else redirect login?
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.shops-list';

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('Создать')
                ->url('settings'),//TODO valid url
        ];
    }

    protected function getTitle(): string
    {
        return 'Аккаунты';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ListShopsWidget::class,
        ];
    }
}

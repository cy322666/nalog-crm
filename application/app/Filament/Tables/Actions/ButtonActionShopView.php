<?php

namespace App\Filament\Tables\Actions;

use App\Filament\Resources\Shop\TaskResource;
use App\Services\CacheService;
use Filament\Forms\ComponentContainer;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ButtonActionShopView extends Action
{
//    protected ?\Closure $mutateRecordDataUsing = null;

    public static function make(string|null $name = 'click'): static
    {
        return parent::make($name);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('secondary');

        $this->icon('heroicon-s-eye');

        $this->disableForm();

        $this->mountUsing(function (ComponentContainer $form, Model $record): void {

//            Session::put('shop', $record->uuid);

            CacheService::deleteAccountId();

            CacheService::setAccountId($record->id);

            $this->redirect(TaskResource::getUrl());
        });

        $this->action(static function (): void {});
    }
}

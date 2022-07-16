<?php

namespace App\Filament\Tables\Actions;

use Filament\Forms\ComponentContainer;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ButtonActionShopView extends Action
{
    protected ?\Closure $mutateRecordDataUsing = null;

    public static function make(string $name = 'click'): static
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

            Session::put('shop', $record->uuid);

            $this->redirect(route('filament.resources.tasks.index'));
        });

        $this->action(static function (): void {});
    }
}

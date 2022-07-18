<?php

namespace App\Filament\Resources\Shop\ShopResource\Pages;

use App\Filament\Resources\Shop\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class EditShop extends EditRecord
{
    protected static string $resource = ShopResource::class;
//cog icon TODO
    protected function getActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return "\n";
    }

    public function payButtonClick(int $shop_id)
    {
        $this->redirect(Config::get('crm.url_support'));//$shop_id
    }

    public function employeesButtonClick()
    {
        $this->redirect(route('filament.resources.users.index'));
    }

    public function supportButtonClick()
    {
        $this->redirect(Config::get('crm.url_support'));//$shop_id
    }
}

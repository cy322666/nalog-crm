<?php

namespace App\Filament\Tables\Actions;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\Shop\OrderLostReasons;
use App\Models\Shop\OrderSource;
use App\Models\Shop\OrderStatus;
use App\Models\Shop\PaymentMethod;
use App\Models\Shop\PaymentProvider;
use App\Models\Shop\PaymentStatus;
use App\Models\Shop\Shop;
use App\Models\User;
use App\Services\CacheService;
use App\Services\Roles\RoleManager;
use Filament\Forms\ComponentContainer;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Log;

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

        $this->mountUsing(function (ComponentContainer $form): void {

            $shop = $this->record;

            CacheService::reset();

            CacheService::setRole(RoleManager::map($shop));
            CacheService::setAccount($shop);

            PaymentMethod::cacheAll();
            PaymentProvider::cacheAll();
            PaymentStatus::cacheAll();

            //TODO dont work
//            OrderSource::cacheAll();
//            OrderStatus::cacheAll();
//            OrderLostReasons::cacheAll();
//
            User::cacheAll();

            redirect(OrderResource::getUrl('index', ['record' => $shop]));
        });

        $this->action(static function (): void {});
    }
}

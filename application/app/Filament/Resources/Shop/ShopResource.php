<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\ShopResource\Pages\CreateShop;
use App\Filament\Resources\Shop\ShopResource\Pages\EditShop;
use App\Filament\Resources\Shop\ShopResource\Pages\ListShops;
use App\Filament\Tables\Actions\ButtonActionShopPay;
use App\Filament\Tables\Actions\ButtonActionShopView;
use App\Models\Currency;
use App\Models\Shop\PaymentMethod;
use App\Models\Shop\PaymentProvider;
use App\Models\Shop\PaymentStatus;
use App\Models\Shop\Shop;
use App\Models\Timezone;
use App\Services\CacheService;
use App\Services\Roles\RoleManager;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;

    protected static ?string $slug = 'shops';

    //TODO в list дофига запросов
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shop_id')
                    ->sortable()
                    ->label('ID'),

                TextColumn::make('name')
                    ->label('Название'),

                TextColumn::make('expired_at')
                    ->sortable()
                    ->label('Активен до'),

                TextColumn::make('tariff.name')
                    ->sortable()
                    ->label('Тариф'),//TODO тут ссылка на страницу

                BadgeColumn::make('active')
                    ->sortable()
                    ->label('Статус')
                    ->enum([
                        false => 'Не активен',
                        true  => 'Активен',
                    ])
                    ->colors([
                        'danger'  => false,
                        'success' => true,
                    ])
                    ->icons([
                        'heroicon-o-ban' => fn ($state): bool => $state === false,
                        'heroicon-o-badge-check'  => fn ($state): bool => $state === true,
                    ]),
            ])
            ->filters([])
            ->actions([
                ButtonActionShopView::make('Перейти'),
                ButtonActionShopPay::make('Оплатить'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListShops::route('list/'),
            'create' => CreateShop::route('/create'),
            'settings' => EditShop::route('/{record}/edit'),
        ];
    }
}

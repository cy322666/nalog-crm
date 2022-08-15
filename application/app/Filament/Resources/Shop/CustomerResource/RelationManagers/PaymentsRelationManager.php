<?php

namespace App\Filament\Resources\Shop\CustomerResource\RelationManagers;

use Akaunting\Money\Currency;
use App\Filament\Resources\Shop\OrderResource;
use App\Models\Shop\Payment;
use App\Models\Shop\PaymentMethod;
use App\Models\Shop\PaymentProvider;
use App\Models\Shop\PaymentStatus;
use App\Services\CacheService;
use App\Services\Helpers\ModelHelper;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyThroughRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentsRelationManager extends HasManyThroughRelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Платежи';

    public static function form(Form $form): Form
    {
        return $form->schema([])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_id')
                    ->label('ID')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status.name')
                    ->label('Статус')
                    ->colors([
                        'primary' => fn ($state): bool => true,
                        'danger'  => fn ($state): bool => $state === PaymentStatus::LOST_STATUS_NAME,
                        'warning' => fn ($state): bool => $state === PaymentStatus::NEW_STATUS_NAME,
                        'success' => fn ($state): bool => $state === PaymentStatus::WIN_STATUS_NAME,
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('order.name')
                    ->label('Заказ')
                    ->url(fn ($record) => OrderResource::getUrl('edit', [$record->order])),//TODO view,

                Tables\Columns\TextColumn::make('provider.name')
                    ->label('Платежная система')
                    ->sortable(),

                Tables\Columns\TextColumn::make('method.name')
                    ->label('Способ оплаты')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->toggleable(true)
                    ->sortable(),
            ])
            ->headerActions([])
            ->actions([])
            ->filters([]);
    }
}

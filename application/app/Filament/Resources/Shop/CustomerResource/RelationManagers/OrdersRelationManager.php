<?php

namespace App\Filament\Resources\Shop\CustomerResource\RelationManagers;

use App\Filament\Resources\Shop\OrderResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\MorphToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Squire\Models\Country;

class OrdersRelationManager extends MorphToManyRelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $title = 'Заказы';

    protected static ?string $label = 'Заказ';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(OrderResource::table(new Table())->getColumns())
            ->filters([])
            ->actions([])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ]);
    }
}

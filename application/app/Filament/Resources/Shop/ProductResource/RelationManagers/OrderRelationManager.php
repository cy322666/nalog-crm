<?php

namespace App\Filament\Resources\Shop\ProductResource\RelationManagers;

use App\Filament\Resources\Shop\OrderResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\MorphManyRelationManager;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class OrderRelationManager extends MorphManyRelationManager
{
    protected static string $relationship = 'orders';

    public static function getTitle(): string
    {
        return 'Заказы';
    }

    protected function getTableDescription(): ?string
    {
        return 'Активные заказы с этим товаром';
    }

    protected static ?string $recordTitleAttribute = 'title';

    protected function getTableQuery(): Builder|Relation
    {
        return parent::getTableQuery()->where('closed', false);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(OrderResource::table(new Table())->getColumns())
            ->filters([])
            ->actions([]);
    }
}

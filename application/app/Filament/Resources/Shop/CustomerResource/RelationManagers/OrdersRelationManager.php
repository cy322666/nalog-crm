<?php

namespace App\Filament\Resources\Shop\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\MorphToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Squire\Models\Country;

class OrdersRelationManager extends MorphToManyRelationManager
{
    protected static string $relationship = 'orders';

//    protected static ?string $recordTitleAttribute = 'full_address';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('street'),

                Forms\Components\TextInput::make('zip'),

                Forms\Components\TextInput::make('city'),

                Forms\Components\TextInput::make('state'),

                Forms\Components\Select::make('country')
                        ->searchable()
                        ->getSearchResultsUsing(fn (string $query) => Country::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn ($value): ?string => Country::find($value)?->name),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number'),

                Tables\Columns\TextColumn::make('total_price'),

                Tables\Columns\TextColumn::make('status'),

                Tables\Columns\TextColumn::make('currency'),

//                Tables\Columns\TextColumn::make('country')
//                    ->formatStateUsing(fn ($state): ?string => Country::find($state)?->name ?? null),
            ])
            ->filters([
                //
            ]);
    }
}

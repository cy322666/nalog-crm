<?php

namespace App\Filament\Resources\Shop\StockResource\Pages;

use App\Filament\Resources\Shop\StockResource;
use App\Filament\Widgets\StockList;
use App\Filament\Widgets\StockListProducts;
use App\Models\Shop\Product;
use App\Services\CacheService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Page;

class StockProduct extends Page
{
    protected static string $resource = StockResource::class;

    protected static string $view = 'filament.resources.stock-resource.pages.stock-product';

    protected function getTitle(): string
    {
        return 'Склады';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StockList::class,
        ];
    }

    //форма пополнения склада
    protected function getActions(): array
    {
        return [
            Action::make('add')
                ->label('Пополнить')
                ->color('secondary')
                ->form([
                    Select::make('stocks')
                        ->label('Склад')
                        ->options(CacheService::getAccount()->stocks()->pluck('name', 'id'))//TODO не корретно получает шоп
                        ->required(),
                    Select::make('product')
                        ->label('Товар')
                        ->searchable()
                        ->getSearchResultsUsing(fn (string $query) => Product::query()
                            ->where('shop_id', CacheService::getAccount()->id)
                            ->where('name', 'like', "%{$query}%")
                            ->pluck('name', 'id')
                        )
                        ->getOptionLabelUsing(fn ($value): ?string => Product::query()->find($value)?->name),
                    TextInput::make('count')
                        ->label('Количество')
                        ->numeric()
                        ->default(1)
                        ->rules(['integer', 'min:0'])
                ])
                ->modalButton('Подтвердить')
                ->modalWidth('md')
                ->action('submit'),

            Action::make('create')
                ->label('Создать')
                ->url(StockResource::getUrl('create')),
        ];
    }

    public function submit(array $data)
    {
        $stockProduct = \App\Models\Shop\StockProduct::query()
            ->where('product_id', $data['product'])
            ->where('stock_id', $data['stocks'])
            ->first();

        if ($stockProduct) {

            $stockProduct->count += $data['count'];
            $stockProduct->save();
        } else {
            \App\Models\Shop\StockProduct::query()
                ->create([
                    'product_id' => $data['product'],
                    'stock_id'   => $data['stocks'],
                    'count'      => $data['count'],
                ]);
        }

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }

    protected function getFooterWidgets(): array
    {
        return [
            StockListProducts::class,
        ];
    }
}

<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Details')
                            ->icon(Heroicon::OutlinedInformationCircle)
                            ->schema([
                                TextEntry::make('title')
                                    ->columnSpanFull(),
                                TextEntry::make('description')
                                    ->placeholder('-')
                                    ->columnSpanFull(),
                                TextEntry::make('category.title')
                                    ->label('Category')
                                    ->badge(),
                                IconEntry::make('is_active')
                                    ->label('Active')
                                    ->boolean(),
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ])
                            ->columns(2),
                        Tab::make('Pricing & Timing')
                            ->icon(Heroicon::OutlinedCurrencyDollar)
                            ->schema([
                                TextEntry::make('price')
                                    ->money(),
                                TextEntry::make('discount_price')
                                    ->money()
                                    ->placeholder('-'),
                                TextEntry::make('preparation_time')
                                    ->numeric()
                                    ->suffix(' min')
                                    ->placeholder('-'),
                            ])
                            ->columns(2),
                        Tab::make('Merchandising')
                            ->icon(Heroicon::OutlinedSparkles)
                            ->schema([
                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                                IconEntry::make('is_new')
                                    ->label('New')
                                    ->boolean(),
                            ])
                            ->columns(2),
                        Tab::make('Variants')
                            ->icon(Heroicon::OutlinedRectangleStack)
                            ->schema([
                                RepeatableEntry::make('variants')
                                    ->hiddenLabel()
                                    ->placeholder('No variants')
                                    ->schema([
                                        TextEntry::make('name'),
                                        TextEntry::make('price')
                                            ->money(),
                                        TextEntry::make('discount_price')
                                            ->money()
                                            ->placeholder('-'),
                                    ])
                                    ->columns(3),
                            ]),
                    ]),
            ]);
    }
}

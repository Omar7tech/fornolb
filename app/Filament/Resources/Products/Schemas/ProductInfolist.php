<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->placeholder('-'),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_new')
                    ->boolean(),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('discount_price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('preparation_time')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('sort')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('category.title')
                    ->label('Category'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

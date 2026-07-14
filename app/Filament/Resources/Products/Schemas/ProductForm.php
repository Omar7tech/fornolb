<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductForm
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
                                TextInput::make('title')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('description')
                                    ->default(null)
                                    ->placeholder('No description')
                                    ->columnSpanFull(),
                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'title')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Toggle::make('is_active')
                                    ->required()
                                    ->default(true),
                                SpatieMediaLibraryFileUpload::make('image')
                                    ->collection('image')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->image()
                                    ->conversion('webp')
                                    ->responsiveImages()
                                    ->imageEditor()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Pricing & Timing')
                            ->icon(Heroicon::OutlinedCurrencyDollar)
                            ->schema([
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->default(0.0)
                                    ->prefix('$'),
                                TextInput::make('discount_price')
                                    ->numeric()
                                    ->default(null)
                                    ->prefix('$')
                                    ->placeholder('No discount'),
                                TextInput::make('preparation_time')
                                    ->numeric()
                                    ->default(null)
                                    ->placeholder('Not specified')
                                    ->suffix('min'),
                            ])
                            ->columns(2),
                        Tab::make('Merchandising')
                            ->icon(Heroicon::OutlinedSparkles)
                            ->schema([
                                Toggle::make('is_featured'),
                                Toggle::make('is_new'),
                            ])
                            ->columns(2),
                        Tab::make('Variants')
                            ->icon(Heroicon::OutlinedRectangleStack)
                            ->schema([
                                Repeater::make('variants')
                                    ->hiddenLabel()
                                    ->table([
                                        TableColumn::make('Name')->markAsRequired(),
                                        TableColumn::make('Price')->markAsRequired(),
                                        TableColumn::make('Discount price'),
                                    ])
                                    ->compact()
                                    ->addActionLabel('Add variant')
                                    ->reorderable()
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('price')
                                            ->required()
                                            ->numeric()
                                            ->minValue(0),
                                        TextInput::make('discount_price')
                                            ->numeric()
                                            ->minValue(0),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}

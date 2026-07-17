<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use App\Filament\Tables\Columns\PriceColumn;
use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Schema $schema): Schema
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
                                    // Most products have no variants, so start
                                    // empty rather than making the blank row
                                    // Filament adds by default fail validation.
                                    ->defaultItems(0)
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->label('Image')
                    ->collection('image')
                    ->conversion('webp')
                    ->circular(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(),
                ToggleColumn::make('is_featured')
                    ->label('Featured')
                    ->toggleable(),
                ToggleColumn::make('is_new')
                    ->label('New')
                    ->toggleable(),
                PriceColumn::make('price')
                    ->label('Price')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        /** @var Builder<Product> $query */
                        return $query->orderByEffectivePrice($direction);
                    }),
                TextColumn::make('preparation_time')
                    ->label('Prep. time')
                    ->formatStateUsing(fn (?int $state): ?string => $state === null ? null : "{$state} ".Str::plural('min', $state))
                    ->placeholder('-')
                    ->color('warning')
                    ->badge()
                    ->sortable()
                    ->toggleable(),
                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->onColor('success'),
                TextColumn::make('variants')
                    ->label('Variants')
                    ->state(fn (Product $record): ?int => filled($record->variants) ? count($record->variants) : null)
                    ->badge()
                    ->color('info')
                    ->placeholder('None')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->filters([
                TernaryFilter::make('discount_price')
                    ->label('Discount')
                    ->placeholder('All products')
                    ->trueLabel('On discount')
                    ->falseLabel('Full price')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('discount_price'),
                        false: fn (Builder $query): Builder => $query->whereNull('discount_price'),
                        blank: fn (Builder $query): Builder => $query,
                    ),
                TernaryFilter::make('variants')
                    ->label('Variants')
                    ->placeholder('All products')
                    ->trueLabel('Has variants')
                    ->falseLabel('No variants')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('variants'),
                        false: fn (Builder $query): Builder => $query->whereNull('variants'),
                        blank: fn (Builder $query): Builder => $query,
                    ),
                TernaryFilter::make('is_active')
                    ->label('Active'),
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
                TernaryFilter::make('is_new')
                    ->label('New'),
            ])
            ->filtersFormColumns(2)
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

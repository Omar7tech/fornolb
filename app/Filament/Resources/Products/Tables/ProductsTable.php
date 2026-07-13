<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\Tables\Columns\PriceColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
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
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderByEffectivePrice($direction)),
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
                TextColumn::make('category.title')
                    ->label('Category')
                    ->badge()
                    ->searchable()
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
                SelectFilter::make('category')
                    ->label('Category')
                    ->relationship('category', 'title')
                    ->searchable()
                    ->preload(),
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
                TernaryFilter::make('is_active')
                    ->label('Active'),
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
                TernaryFilter::make('is_new')
                    ->label('New'),
            ])
            ->filtersFormColumns(2)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

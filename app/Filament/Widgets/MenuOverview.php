<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class MenuOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    /**
     * A menu changes when someone edits it, not on a timer, so there is nothing
     * for a poll to pick up.
     */
    protected ?string $pollingInterval = null;

    /**
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        return [
            $this->liveProductsStat(),
            $this->categoriesStat(),
            $this->discountsStat(),
        ];
    }

    /**
     * What a customer can actually see, and what is sitting hidden behind it.
     */
    private function liveProductsStat(): Stat
    {
        $live = Product::query()->where('is_active', true)->count();
        $hidden = Product::query()->where('is_active', false)->count();

        return Stat::make('Live products', Number::format($live))
            ->description($hidden === 0 ? 'Everything is on the menu' : "{$hidden} hidden from the menu")
            ->descriptionIcon($hidden === 0 ? 'heroicon-m-check-circle' : 'heroicon-m-eye-slash')
            ->color($hidden === 0 ? 'success' : 'warning');
    }

    /**
     * An active category with nothing live inside it renders as an empty heading
     * on the storefront, so it is worth surfacing.
     */
    private function categoriesStat(): Stat
    {
        $active = Category::query()->where('is_active', true);

        $total = (clone $active)->count();
        $empty = (clone $active)
            ->whereDoesntHave('products', fn ($query) => $query->where('is_active', true))
            ->count();

        return Stat::make('Active categories', Number::format($total))
            ->description($empty === 0 ? 'All have live products' : "{$empty} with no live products")
            ->descriptionIcon($empty === 0 ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
            ->color($empty === 0 ? 'success' : 'danger');
    }

    private function discountsStat(): Stat
    {
        $discounted = Product::query()
            ->where('is_active', true)
            ->whereNotNull('discount_price')
            ->get(['price', 'discount_price']);

        // Only products with a real price can show a meaningful percentage off.
        $measurable = $discounted->where('price', '>', 0);

        $averageSaving = $measurable->isEmpty()
            ? null
            : $measurable->avg(fn (Product $product): float => 1 - ($product->discount_price / $product->price));

        return Stat::make('On discount', Number::format($discounted->count()))
            ->description($averageSaving === null ? 'No discounts running' : Number::percentage($averageSaving * 100, maxPrecision: 0).' off on average')
            ->descriptionIcon('heroicon-m-tag')
            ->color($discounted->isEmpty() ? 'gray' : 'info');
    }
}

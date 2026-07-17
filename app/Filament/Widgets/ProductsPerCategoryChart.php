<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class ProductsPerCategoryChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Menu balance';

    protected ?string $pollingInterval = null;

    public function getDescription(): ?string
    {
        return 'Live products in each active category.';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $categories = $this->liveCounts();

        return [
            'datasets' => [
                [
                    'label' => 'Live products',
                    'data' => $categories->values()->all(),
                    'backgroundColor' => '#398189',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $categories->keys()->all(),
        ];
    }

    /**
     * Biggest category first, so the lopsided parts of the menu are the first
     * thing you see.
     *
     * @return Collection<string, int>
     */
    private function liveCounts(): Collection
    {
        return Category::query()
            ->where('is_active', true)
            ->withCount(['products as live_products_count' => fn ($query) => $query->where('is_active', true)])
            ->orderByDesc('live_products_count')
            ->get()
            ->mapWithKeys(fn (Category $category): array => [$category->title => $category->live_products_count]);
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                // Product counts are whole numbers, so half-step gridlines are noise.
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['precision' => 0],
                ],
            ],
        ];
    }
}

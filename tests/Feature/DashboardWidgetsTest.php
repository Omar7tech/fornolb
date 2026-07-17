<?php

use App\Filament\Widgets\MenuOverview;
use App\Filament\Widgets\ProductsPerCategoryChart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

/**
 * Pull the rendered stats out of the widget, keyed by label, so the assertions
 * read as the numbers a user would see rather than as Livewire internals.
 *
 * @return array<string, array{value: string, description: string|null}>
 */
function menuStats(): array
{
    $stats = livewire(MenuOverview::class)->instance()->getCachedStats();

    return collect($stats)
        ->mapWithKeys(fn ($stat) => [
            $stat->getLabel() => [
                'value' => $stat->getValue(),
                'description' => $stat->getDescription(),
            ],
        ])
        ->all();
}

it('counts live products separately from hidden ones', function () {
    $category = Category::factory()->create(['is_active' => true]);

    Product::factory()->count(3)->for($category)->create(['is_active' => true]);
    Product::factory()->count(2)->for($category)->create(['is_active' => false]);

    expect(menuStats()['Live products'])
        ->value->toBe('3')
        ->description->toBe('2 hidden from the menu');
});

it('flags active categories with no live products', function () {
    $stocked = Category::factory()->create(['is_active' => true]);
    Product::factory()->for($stocked)->create(['is_active' => true]);

    // Active, but everything inside it is hidden — renders as an empty heading.
    $empty = Category::factory()->create(['is_active' => true]);
    Product::factory()->for($empty)->create(['is_active' => false]);

    Category::factory()->create(['is_active' => false]);

    expect(menuStats()['Active categories'])
        ->value->toBe('2')
        ->description->toBe('1 with no live products');
});

it('averages the discount across discounted products only', function () {
    $category = Category::factory()->create(['is_active' => true]);

    Product::factory()->for($category)->create([
        'is_active' => true,
        'price' => 10.00,
        'discount_price' => 8.00, // 20% off
    ]);

    Product::factory()->for($category)->create([
        'is_active' => true,
        'price' => 10.00,
        'discount_price' => 6.00, // 40% off
    ]);

    Product::factory()->for($category)->create([
        'is_active' => true,
        'price' => 10.00,
        'discount_price' => null,
    ]);

    expect(menuStats()['On discount'])
        ->value->toBe('2')
        ->description->toBe('30% off on average');
});

it('stays quiet when there is no menu yet', function () {
    expect(menuStats())
        ->{'Live products'}->value->toBe('0')
        ->{'On discount'}->description->toBe('No discounts running');
});

it('charts live products per category, biggest first', function () {
    $mains = Category::factory()->create(['title' => 'Manakish', 'is_active' => true]);
    Product::factory()->count(2)->for($mains)->create(['is_active' => true]);
    Product::factory()->for($mains)->create(['is_active' => false]);

    $drinks = Category::factory()->create(['title' => 'Drinks', 'is_active' => true]);
    Product::factory()->count(4)->for($drinks)->create(['is_active' => true]);

    Category::factory()->create(['title' => 'Retired', 'is_active' => false]);

    $data = livewire(ProductsPerCategoryChart::class)->instance()->getCachedData();

    expect($data['labels'])->toBe(['Drinks', 'Manakish'])
        ->and($data['datasets'][0]['data'])->toBe([4, 2]);
});

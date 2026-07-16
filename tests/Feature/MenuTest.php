<?php

use App\Enums\PriceDisplay;
use App\Models\Category;
use App\Models\Product;
use App\Settings\GeneralSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

/**
 * Point the storefront's shared pricing settings at a known state.
 */
function pricingSettings(PriceDisplay $display, bool $showLbp = true, ?float $rate = 90000): void
{
    $settings = app(GeneralSettings::class);
    $settings->price_display = $display;
    $settings->show_lbp_prices = $showLbp;
    $settings->lbp_exchange_rate = $rate;
    $settings->save();
}

test('the menu page lists active categories with their products', function () {
    $category = Category::factory()->create(['title' => 'Manakish', 'is_active' => true]);
    Product::factory()->for($category)->create(['title' => 'Zaatar', 'is_active' => true]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('welcome')
            ->has('categories', 1)
            ->where('categories.0.title', 'Manakish')
            ->has('categories.0.products', 1)
            ->where('categories.0.products.0.title', 'Zaatar')
        );
});

test('inactive categories are hidden from the menu', function () {
    $category = Category::factory()->create(['is_active' => false]);
    Product::factory()->for($category)->create(['is_active' => true]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->has('categories', 0));
});

test('inactive products are hidden from the menu', function () {
    $category = Category::factory()->create(['is_active' => true]);
    Product::factory()->for($category)->create(['is_active' => true]);
    Product::factory()->for($category)->create(['title' => 'Hidden', 'is_active' => false]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->has('categories.0.products', 1));
});

test('categories without visible products are dropped', function () {
    Category::factory()->create(['is_active' => true]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->has('categories', 0));
});

test('categories and products are ordered by their sort column', function () {
    $second = Category::factory()->create(['title' => 'Second', 'sort' => 2, 'is_active' => true]);
    $first = Category::factory()->create(['title' => 'First', 'sort' => 1, 'is_active' => true]);

    Product::factory()->for($first)->create(['title' => 'Later', 'sort' => 2, 'is_active' => true]);
    Product::factory()->for($first)->create(['title' => 'Earlier', 'sort' => 1, 'is_active' => true]);
    Product::factory()->for($second)->create(['is_active' => true]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('categories.0.title', 'First')
            ->where('categories.1.title', 'Second')
            ->where('categories.0.products.0.title', 'Earlier')
            ->where('categories.0.products.1.title', 'Later')
        );
});

test('a discounted product exposes both prices to the storefront', function () {
    $category = Category::factory()->create(['is_active' => true]);
    Product::factory()->for($category)->create([
        'price' => 12.50,
        'discount_price' => 9.75,
        'is_active' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('categories.0.products.0.price', 12.5)
            ->where('categories.0.products.0.discount_price', 9.75)
        );
});

test('the storefront is told which currency to display', function () {
    pricingSettings(PriceDisplay::BOTH);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('pricing.display', 'both')
            // A whole float survives JSON as an int, so compare loosely here.
            ->where('pricing.lbpRate', fn (int|float $rate): bool => (float) $rate === 90000.0)
        );
});

test('the lbp rate is withheld when lbp prices are switched off', function () {
    pricingSettings(PriceDisplay::LBP, showLbp: false);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->where('pricing.lbpRate', null));
});

test('the lbp rate is withheld when no exchange rate is configured', function () {
    pricingSettings(PriceDisplay::BOTH, rate: null);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->where('pricing.lbpRate', null));
});

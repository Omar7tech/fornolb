<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

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

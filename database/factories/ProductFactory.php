<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(3, true);
        $price = fake()->randomFloat(2, 5, 100);
        return [
            'title' => $title,
            'description' => fake()->paragraph(),
            'is_featured' => fake()->boolean(20),
            'is_new' => fake()->boolean(30),
            'price' => $price,
            'discount_price' => fake()->boolean(40) ? fake()->randomFloat(2, $price * 0.5, $price * 0.9) : null,
            'preparation_time' => fake()->numberBetween(10, 60),
            'sort' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'category_id' => Category::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
            'description' => fake()->sentence(),
            'is_featured' => fake()->boolean(20),
            'is_new' => fake()->boolean(30),
            'is_spicy' => fake()->boolean(15),
            'is_vegetarian' => fake()->boolean(25),
            'price' => $price,
            'discount_price' => fake()->boolean(40) ? fake()->randomFloat(2, $price * 0.5, $price * 0.9) : null,
            'preparation_time' => fake()->numberBetween(10, 60),
            'sort' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'category_id' => Category::factory(),
            'variants' => fake()->boolean(40) ? $this->variants() : null,
        ];
    }

    /**
     * Generate a small set of product variants.
     *
     * @return list<array{name: string, price: float, discount_price: float|null}>
     */
    protected function variants(): array
    {
        /** @var list<string> $names */
        $names = (array) Arr::random(['Small', 'Medium', 'Large', 'Family', 'Spicy', 'Extra cheese'], fake()->numberBetween(2, 3));

        $variants = [];

        foreach ($names as $name) {
            $price = (float) fake()->randomElement([3.00, 5.50, 8.00, 11.00, 15.00]);

            $variants[] = [
                'name' => (string) $name,
                'price' => $price,
                'discount_price' => fake()->boolean(25) ? round($price * 0.8, 2) : null,
            ];
        }

        return $variants;
    }
}

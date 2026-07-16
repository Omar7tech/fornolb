<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->keyBy('title');

        foreach ($this->menu() as $categoryTitle => $products) {
            $category = $categories->get($categoryTitle);

            if ($category === null) {
                continue;
            }

            foreach ($products as $sort => $product) {
                Product::firstOrCreate(
                    ['title' => $product['title']],
                    [
                        ...$product,
                        'sort' => $sort + 1,
                        'is_active' => true,
                        'category_id' => $category->id,
                    ],
                );
            }
        }
    }

    /**
     * The menu, keyed by category title. Prices are in USD; the storefront
     * converts to LBP at the configured rate.
     *
     * @return array<string, list<array{title: string, description?: string, price: float}>>
     */
    protected function menu(): array
    {
        return [
            'Pizza Manousheh' => [
                ['title' => 'Zaatar', 'price' => 1.00],
                ['title' => 'Zaatar Deluxe', 'price' => 1.50],
                ['title' => 'Zaatar ma3 Jebne', 'price' => 2.00],
                ['title' => 'Kishk', 'price' => 1.25],
                ['title' => 'Kishk Deluxe', 'price' => 2.00],
                ['title' => 'Kishk ma3 Jebne', 'price' => 2.50],
                ['title' => 'Akawi ma3 Mozza', 'price' => 2.50],
            ],

            'Pick n Roll' => [
                [
                    'title' => 'Cheese Steak',
                    'description' => 'Cheese loaded, sliced beef steak, onion, peppers, lettuce, bbq relish sauce.',
                    'price' => 6.50,
                ],
                [
                    'title' => 'Truffle Steak',
                    'description' => 'Cheese loaded with a slice of beef steak, caramelized onion and mushrooms, truffle aioli sauce, baby rocca, balsamic, parmigiana.',
                    'price' => 7.50,
                ],
                [
                    'title' => 'Peri Peri',
                    'description' => 'Grilled chicken, melted cheese, garlic aioli, pickles, shredded iceberg, tomato, spicy peri peri sauce.',
                    'price' => 4.50,
                ],
                [
                    'title' => 'Francisco Chicken',
                    'description' => 'Grilled chicken, melted cheese, garlic aioli, shredded iceberg, pickles, corn.',
                    'price' => 4.50,
                ],
                [
                    'title' => 'Tawouk',
                    'description' => 'Grilled chicken, garlic, fries, coleslaw, pickles, ketchup.',
                    'price' => 4.50,
                ],
                [
                    'title' => 'Forno Italian Deluxe',
                    'description' => 'Fresh deli cold cuts, salami, pepperoni, turkey, cheese, pesto parmigiana ranch, tomato, lettuce.',
                    'price' => 5.00,
                ],
                [
                    'title' => 'Crunchy Chicken',
                    'description' => 'Crunchy crispy chicken, melted cheese, bbq sauce, lettuce, honey mustard sauce, pickles.',
                    'price' => 4.50,
                ],
            ],

            'Pizza' => [
                [
                    'title' => 'Vegetarian',
                    'description' => 'Tomato sauce, mushroom, peppers, onion, cherry tomato, sweet corn, olives, mozzarella, baby rocca, parmigiana.',
                    'price' => 10.50,
                ],
                [
                    'title' => 'Margarita',
                    'description' => 'Tomato sauce, mozzarella, parmigiana.',
                    'price' => 9.00,
                ],
                [
                    'title' => 'Bbq Chicken',
                    'description' => 'Bbq relish sauce, chicken, mushroom, peppers, onion, sweet corn, mozzarella.',
                    'price' => 11.50,
                ],
                [
                    'title' => 'Creole Chicken',
                    'description' => 'Creole sauce, chicken, onion, pepper, cherry tomato, mozzarella.',
                    'price' => 11.50,
                ],
                [
                    'title' => 'Pepperoni Cheese',
                    'description' => 'Tomato sauce, mozzarella, beef pepperoni.',
                    'price' => 10.50,
                ],
                [
                    'title' => 'Chicken Ranch',
                    'description' => 'Ranch sauce, mushroom, chicken, mozzarella, baby rocca.',
                    'price' => 10.50,
                ],
                [
                    'title' => 'Double Double Cheese',
                    'price' => 9.50,
                ],
                [
                    'title' => 'Nyk Bbq Beef',
                    'price' => 13.50,
                ],
                [
                    'title' => 'Truffle Cream',
                    'description' => 'Truffle sauce, mushroom, onion, mozzarella, baby rocca, balsamic, parmigiana.',
                    'price' => 13.00,
                ],
            ],

            'Pizza Sandwich' => [
                [
                    'title' => 'Halloumi Mozza Pesto',
                    'description' => 'Grilled halloumi, melted cheese, a touch of pesto basil, cherry tomato, baby rocca, white sauce.',
                    'price' => 7.75,
                ],
                [
                    'title' => 'Hawain',
                    'description' => 'Pizza sauce, smoked turkey, pineapple, melted cheese, baby rocca.',
                    'price' => 6.50,
                ],
                [
                    'title' => 'Hot Honey Pepperoni',
                    'description' => 'Pizza sauce, pepperoni, melted cheese, hot honey, baby rocca.',
                    'price' => 6.50,
                ],
                [
                    'title' => 'Pesto Chicken',
                    'description' => 'Grilled chicken, melted cheese, pesto basil, arugula, onions, peppers, tomato, creamy garlic.',
                    'price' => 7.50,
                ],
                [
                    'title' => 'Turkey n Cheese',
                    'description' => 'Melted mozzarella, turkey slice, iceberg, arugula, honey mustard sauce, pickles.',
                    'price' => 6.25,
                ],
                [
                    'title' => 'Crispy Chicken Cesar',
                    'description' => 'Crispy chicken, lettuce mixed with a special Cesar sauce.',
                    'price' => 6.00,
                ],
                [
                    'title' => 'Crispy Caprese',
                    'description' => 'Crispy chicken, cherry tomato, mozzarella, a touch of balsamic and olive oil, parmigiana, fresh basil.',
                    'price' => 6.00,
                ],
            ],

            'Pasta' => [
                [
                    'title' => 'Chicken Alfredo',
                    'description' => 'Baked on request with mozzarella on top.',
                    'price' => 9.00,
                ],
                [
                    'title' => 'Pesto Chicken Pasta',
                    'description' => 'Baked on request with mozzarella on top.',
                    'price' => 9.50,
                ],
                [
                    'title' => 'Truffle Chicken',
                    'description' => 'Baked on request with mozzarella on top.',
                    'price' => 10.00,
                ],
            ],

            'Starters' => [
                ['title' => 'Fries', 'price' => 2.50],
                ['title' => 'Mozzarella Sticks', 'description' => '5 pieces.', 'price' => 5.00],
                ['title' => '3 Pcs Crispy with Fries', 'price' => 5.00],
                ['title' => 'Truffle Fries', 'price' => 5.00],
            ],

            'Salad' => [
                ['title' => 'Cezar Salad', 'price' => 5.00],
                ['title' => 'Chicken Cezar Salad', 'price' => 6.50],
                ['title' => 'Forno Salad', 'price' => 8.00],
            ],

            'Sweets' => [
                ['title' => 'Nutella Banana', 'price' => 4.00],
                ['title' => 'Areshy w 3asal', 'price' => 5.00],
            ],
        ];
    }
}

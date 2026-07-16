<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * The menu sections, in the order they appear on the site.
     *
     * @var list<string>
     */
    public const TITLES = [
        'Starters',
        'Salad',
        'Pizza Manousheh',
        'Pick n Roll',
        'Pizza',
        'Pizza Sandwich',
        'Pasta',
        'Sweets',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::TITLES as $sort => $title) {
            Category::firstOrCreate(
                ['title' => $title],
                ['sort' => $sort + 1, 'is_active' => true],
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\Relation;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function __invoke(): Response
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with(['products' => function (Relation $query): void {
                $query
                    ->with('media')
                    ->where('is_active', true)
                    ->orderBy('sort');
            }])
            ->orderBy('sort')
            ->get()
            // An empty category would render a heading and a filter pill that
            // scrolls to nothing, so drop it.
            ->filter(fn (Category $category): bool => $category->products->isNotEmpty())
            ->values();

        return Inertia::render('welcome', [
            'categories' => CategoryResource::collection($categories)->resolve(),
        ]);
    }
}

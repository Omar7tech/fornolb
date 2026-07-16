<?php

use App\Http\Controllers\MenuController;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', MenuController::class)->name('home');

// Served by Laravel rather than as static files, so the URLs inside them resolve
// from APP_URL — robots.txt requires the sitemap link to be absolute.
Route::get('robots.txt', fn (): Response => response(view('seo.robots'))
    ->header('Content-Type', 'text/plain'))
    ->name('robots');

Route::get('sitemap.xml', fn (): Response => response(view('seo.sitemap', [
    // The menu changing is the only thing that dates this page.
    'lastModified' => Carbon::make(Product::max('updated_at')),
]))->header('Content-Type', 'application/xml'))
    ->name('sitemap');

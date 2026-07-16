<?php

namespace App\Support;

use App\Enums\ShopStatusMode;
use App\Enums\SocialPlatform;
use App\Settings\GeneralSettings;

/**
 * Builds the schema.org JSON-LD for the storefront.
 *
 * The site is an Inertia app without SSR, so crawlers get an empty `<div>` and
 * nothing else. This is what actually describes the business and the menu to
 * them, which is why it's assembled server-side into the root Blade view.
 *
 * @see https://schema.org/Restaurant
 */
class RestaurantSchema
{
    public function __construct(private readonly GeneralSettings $settings) {}

    /**
     * The full graph: the restaurant, its menu, and the website itself.
     *
     * @param  list<array<string, mixed>>  $categories  Resolved `CategoryResource` data.
     * @return array<string, mixed>
     */
    public function build(array $categories): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $this->restaurant($categories),
                $this->website(),
            ],
        ];
    }

    /**
     * @param  list<array<string, mixed>>  $categories
     * @return array<string, mixed>
     */
    protected function restaurant(array $categories): array
    {
        return array_filter([
            '@type' => 'Restaurant',
            '@id' => url('/').'#restaurant',
            'name' => config('seo.name'),
            'alternateName' => config('seo.alternate_name'),
            'description' => config('seo.description'),
            'url' => url('/'),
            'image' => asset(config('seo.og_image')),
            'logo' => asset('logos/main-logo.png'),
            'telephone' => $this->settings->show_phone ? $this->settings->phone_number : null,
            'address' => $this->address(),
            'geo' => $this->geo(),
            'hasMap' => config('seo.map_url'),
            'servesCuisine' => config('seo.cuisines'),
            'priceRange' => config('seo.price_range'),
            'currenciesAccepted' => config('seo.currency'),
            'openingHoursSpecification' => $this->openingHours(),
            'sameAs' => $this->sameAs(),
            'hasMenu' => $this->menu($categories),
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }

    /**
     * @return array<string, mixed>
     */
    protected function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'name' => config('seo.name'),
            'url' => url('/'),
            'publisher' => ['@id' => url('/').'#restaurant'],
            'inLanguage' => 'en',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function address(): array
    {
        return array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => config('seo.address.street'),
            'addressLocality' => config('seo.address.locality'),
            'addressRegion' => config('seo.address.region'),
            'addressCountry' => config('seo.address.country'),
            // Google's own identifier for the spot, and the most precise thing
            // available given Aley addresses aren't street-numbered.
            'description' => config('seo.address.plus_code'),
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * The map pin. Left out entirely until both coordinates are configured — a
     * half-filled `GeoCoordinates` is worse than none.
     *
     * @return array<string, mixed>|null
     */
    protected function geo(): ?array
    {
        $latitude = config('seo.geo.latitude');
        $longitude = config('seo.geo.longitude');

        if ($latitude === null || $longitude === null) {
            return null;
        }

        return [
            '@type' => 'GeoCoordinates',
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }

    /**
     * The weekly schedule, but only when it's the authority on whether the shop
     * is open. In manual mode the schedule isn't maintained, and publishing
     * hours that turn out to be wrong is worse than publishing none.
     *
     * @return list<array<string, mixed>>
     */
    protected function openingHours(): array
    {
        if ($this->settings->status_mode !== ShopStatusMode::AUTOMATIC) {
            return [];
        }

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $specification = [];

        foreach ($this->settings->opening_hours as $hours) {
            if ($hours['is_closed'] ?? false) {
                continue;
            }

            $day = $days[$hours['day']] ?? null;

            if ($day === null) {
                continue;
            }

            $specification[] = [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => "https://schema.org/{$day}",
                'opens' => $hours['opens_at'],
                'closes' => $hours['closes_at'],
            ];
        }

        return $specification;
    }

    /**
     * The profiles that confirm this is the same business elsewhere on the web.
     *
     * @return list<string>
     */
    protected function sameAs(): array
    {
        return array_values(collect($this->settings->social_links)
            ->map(function (mixed $link): ?string {
                if (! is_array($link)) {
                    return null;
                }

                $platform = $link['platform'] ?? null;
                $platform = $platform instanceof SocialPlatform
                    ? $platform
                    : SocialPlatform::tryFrom((string) $platform);

                // A WhatsApp number isn't a profile page, so it says nothing
                // about identity and doesn't belong in `sameAs`.
                if ($platform === null || $platform === SocialPlatform::WHATSAPP) {
                    return null;
                }

                return blank($link['url'] ?? null) ? null : (string) $link['url'];
            })
            ->filter()
            ->all());
    }

    /**
     * The menu, as sections of items. This is the part that can earn rich
     * results: every product, its price, and what it's made of.
     *
     * @param  list<array<string, mixed>>  $categories
     * @return array<string, mixed>
     */
    protected function menu(array $categories): array
    {
        return [
            '@type' => 'Menu',
            '@id' => url('/').'#menu',
            'name' => config('seo.name').' Menu',
            'inLanguage' => 'en',
            'hasMenuSection' => array_map(fn (array $category): array => [
                '@type' => 'MenuSection',
                'name' => $category['title'],
                'hasMenuItem' => array_map($this->menuItem(...), $category['products']),
            ], $categories),
        ];
    }

    /**
     * @param  array<string, mixed>  $product
     * @return array<string, mixed>
     */
    protected function menuItem(array $product): array
    {
        return array_filter([
            '@type' => 'MenuItem',
            'name' => $product['title'],
            'description' => $product['description'],
            'image' => $product['image'],
            'suitableForDiet' => $product['is_vegetarian'] ? 'https://schema.org/VegetarianDiet' : null,
            'offers' => $this->offers($product),
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }

    /**
     * A price per variant when the product has them, otherwise a single price.
     * Discounted items advertise the price actually charged.
     *
     * @param  array<string, mixed>  $product
     * @return list<array<string, mixed>>
     */
    protected function offers(array $product): array
    {
        $variants = $product['variants'] ?? null;

        if (is_array($variants) && $variants !== []) {
            return array_values(array_map(fn (array $variant): array => $this->offer(
                $variant['discount_price'] ?? $variant['price'],
                $variant['name'],
            ), $variants));
        }

        return [$this->offer($product['discount_price'] ?? $product['price'])];
    }

    /**
     * @return array<string, mixed>
     */
    protected function offer(float|int|string $price, ?string $name = null): array
    {
        return array_filter([
            '@type' => 'Offer',
            'name' => $name,
            'price' => number_format((float) $price, 2, '.', ''),
            'priceCurrency' => config('seo.currency'),
            'availability' => 'https://schema.org/InStock',
        ], static fn (mixed $value): bool => $value !== null);
    }
}

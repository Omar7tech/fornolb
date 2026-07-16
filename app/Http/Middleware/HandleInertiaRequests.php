<?php

namespace App\Http\Middleware;

use App\Enums\SocialPlatform;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $settings = app(GeneralSettings::class);

        // LBP is only usable when it's switched on *and* a rate exists to convert
        // with; without one the storefront has to fall back to USD.
        $lbpEnabled = $settings->show_lbp_prices && (float) $settings->lbp_exchange_rate > 0;

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'shop' => [
                // Authoritative open/closed snapshot for this request (used for the
                // initial render); the client can recompute live in automatic mode.
                'isOpen' => $settings->isCurrentlyOpen(),
                'statusMode' => $settings->status_mode->value,
                'isManuallyOpen' => $settings->is_open,
                'openingHours' => array_map(static fn (array $hours): array => [
                    'day' => $hours['day'],
                    'isClosed' => $hours['is_closed'],
                    'opensAt' => $hours['opens_at'],
                    'closesAt' => $hours['closes_at'],
                ], array_values($settings->opening_hours)),
            ],
            'pricing' => [
                'display' => $settings->price_display->value,
                'lbpRate' => $lbpEnabled ? (float) $settings->lbp_exchange_rate : null,
            ],
            // Each line is withheld entirely when switched off, so the footer has
            // nothing to render rather than deciding visibility itself.
            'contact' => [
                'address' => $settings->show_address ? $settings->address : null,
                'mapUrl' => $settings->show_address ? $settings->address_map_url : null,
                'phone' => $settings->show_phone ? $settings->phone_number : null,
            ],
            // Floating WhatsApp chat badge config for the storefront.
            'whatsappBadge' => [
                'show' => $settings->show_whatsapp_badge && filled($settings->whatsapp_badge_number),
                'number' => $settings->whatsapp_badge_number,
            ],
            'socials' => collect($settings->social_links)
                ->map(function ($link): ?array {
                    if (! is_array($link)) {
                        return null;
                    }

                    $rawPlatform = $link['platform'] ?? null;
                    $platform = $rawPlatform instanceof SocialPlatform
                        ? $rawPlatform
                        : SocialPlatform::tryFrom((string) $rawPlatform);
                    $url = $link['url'] ?? null;

                    if ($platform === null || blank($url)) {
                        return null;
                    }

                    // Only `OTHER` carries a custom name; the rest use their brand name.
                    $label = $platform === SocialPlatform::OTHER
                        ? ($link['name'] ?? null)
                        : $platform->getLabel();

                    return [
                        'platform' => $platform->value,
                        'label' => blank($label) ? $platform->getLabel() : $label,
                        'url' => $url,
                        'icon' => $platform->getIconPath(),
                    ];
                })
                ->filter()
                ->values()
                ->all(),
        ];
    }
}

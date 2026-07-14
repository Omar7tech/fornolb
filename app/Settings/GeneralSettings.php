<?php

namespace App\Settings;

use App\Enums\PriceDisplay;
use Spatie\LaravelSettings\Settings;
use Spatie\LaravelSettings\SettingsCasts\EnumCast;

class GeneralSettings extends Settings
{
    /**
     * Whether prices can be shown in Lebanese Pounds at all. When off,
     * {@see self::$price_display} always falls back to USD only.
     */
    public bool $show_lbp_prices;

    /**
     * The LBP exchange rate (LBP per 1 USD) used to convert prices.
     */
    public ?float $lbp_exchange_rate;

    /**
     * Which currency prices are displayed in.
     */
    public PriceDisplay $price_display;

    /**
     * Whether the floating WhatsApp chat badge is shown on the storefront.
     */
    public bool $show_whatsapp_badge;

    /**
     * The WhatsApp number the chat badge sends messages to.
     */
    public ?string $whatsapp_badge_number;

    public static function group(): string
    {
        return 'general';
    }

    /**
     * @return array<string, EnumCast>
     */
    public static function casts(): array
    {
        return [
            'price_display' => new EnumCast(PriceDisplay::class),
        ];
    }
}

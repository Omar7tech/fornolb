<?php

namespace App\Settings;

use App\Enums\PriceDisplay;
use App\Enums\ShopStatusMode;
use App\Enums\Weekday;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Spatie\LaravelSettings\Settings;
use Spatie\LaravelSettings\SettingsCasts\EnumCast;

class GeneralSettings extends Settings
{
    /**
     * How the shop's open/closed state is decided: by hand (`MANUAL`) or from
     * the weekly {@see self::$opening_hours} schedule (`AUTOMATIC`).
     */
    public ShopStatusMode $status_mode;

    /**
     * The manual open/closed switch. Only authoritative when the status mode is
     * `MANUAL`.
     */
    public bool $is_open;

    /**
     * The weekly opening-hours schedule used when the status mode is `AUTOMATIC`.
     * One entry per weekday, keyed by JS-style day number (0 = Sunday). Each entry
     * is shaped `['day' => int, 'is_closed' => bool, 'opens_at' => string, 'closes_at' => string]`.
     *
     * Note: no `@var` value type is declared because spatie/laravel-settings cannot
     * resolve a complex array-shape docblock here (it would throw at runtime).
     */
    public array $opening_hours; // @phpstan-ignore missingType.iterableValue

    /**
     * Whether the shop's phone number is shown in the storefront footer.
     */
    public bool $show_phone;

    /**
     * The shop's phone number. Only shown when {@see self::$show_phone} is on.
     */
    public ?string $phone_number;

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

    /**
     * The social media links shown in the storefront footer. Each entry is a
     * single platform paired with its URL, shaped
     * `['platform' => string, 'name' => ?string, 'url' => string]`. The `name`
     * is only used when the platform is `SocialPlatform::OTHER`.
     *
     * Note: no `@var` value type is declared because spatie/laravel-settings cannot
     * resolve a complex array-shape docblock here (it would throw at runtime).
     */
    public array $social_links; // @phpstan-ignore missingType.iterableValue

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
            'status_mode' => new EnumCast(ShopStatusMode::class),
            'price_display' => new EnumCast(PriceDisplay::class),
        ];
    }

    /**
     * The default weekly schedule: every day open from 09:00 to 17:00. Used as
     * the baseline both when seeding settings and when resetting the schedule.
     *
     * @return array<int, array{day: int, is_closed: bool, opens_at: string, closes_at: string}>
     */
    public static function defaultOpeningHours(): array
    {
        return array_map(static fn (Weekday $day): array => [
            'day' => $day->value,
            'is_closed' => false,
            'opens_at' => '09:00',
            'closes_at' => '17:00',
        ], Weekday::cases());
    }

    /**
     * Whether the shop is open right now, resolving the active status mode.
     */
    public function isCurrentlyOpen(?CarbonInterface $now = null): bool
    {
        if ($this->status_mode === ShopStatusMode::MANUAL) {
            return $this->is_open;
        }

        return $this->isWithinSchedule($now ?? Carbon::now());
    }

    /**
     * Whether the given moment falls inside the opening hours for its weekday.
     * Closing times at or before the opening time are treated as crossing
     * midnight (e.g. open 18:00, close 02:00).
     */
    protected function isWithinSchedule(CarbonInterface $now): bool
    {
        $today = collect($this->opening_hours)
            ->firstWhere('day', $now->dayOfWeek);

        if ($today === null || ($today['is_closed'] ?? false)) {
            return false;
        }

        $opensAt = $now->copy()->setTimeFromTimeString($today['opens_at']);
        $closesAt = $now->copy()->setTimeFromTimeString($today['closes_at']);

        if ($closesAt->lessThanOrEqualTo($opensAt)) {
            $closesAt->addDay();
        }

        return $now->betweenIncluded($opensAt, $closesAt);
    }
}

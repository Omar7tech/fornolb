<?php

namespace App\Filament\Pages;

use App\Enums\PriceDisplay;
use App\Enums\ShopStatusMode;
use App\Enums\SocialPlatform;
use App\Enums\Weekday;
use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageGeneral extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static string $settings = GeneralSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Shop Status')
                            ->icon(Heroicon::OutlinedBuildingStorefront)
                            ->schema([
                                Radio::make('status_mode')
                                    ->label('Status mode')
                                    ->validationAttribute('status mode')
                                    ->options(ShopStatusMode::class)
                                    ->default(ShopStatusMode::MANUAL->value)
                                    ->required()
                                    ->columnSpanFull(),

                                Toggle::make('is_open')
                                    ->label('Shop is open')
                                    ->helperText('Turn off to show the storefront as closed.')
                                    ->default(true)
                                    ->columnSpanFull()
                                    ->visibleJs(<<<'JS'
                                        $get('status_mode') === 'manual'
                                        JS),

                                Repeater::make('opening_hours')
                                    ->label('Weekly opening hours')
                                    ->helperText('The shop opens and closes automatically based on these hours.')
                                    ->default(GeneralSettings::defaultOpeningHours())
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->columnSpanFull()
                                    ->itemLabel(fn (array $state): ?string => Weekday::tryFrom($state['day'] ?? -1)?->getLabel())
                                    ->schema([
                                        Hidden::make('day'),

                                        Toggle::make('is_closed')
                                            ->label('Closed (day off)')
                                            ->default(false)
                                            ->columnSpanFull(),

                                        TimePicker::make('opens_at')
                                            ->label('Opens at')
                                            ->validationAttribute('opening time')
                                            ->seconds(false)
                                            ->default('09:00')
                                            ->required()
                                            ->columnSpanFull()
                                            ->visibleJs(<<<'JS'
                                                ! $get('is_closed')
                                                JS),

                                        TimePicker::make('closes_at')
                                            ->label('Closes at')
                                            ->validationAttribute('closing time')
                                            ->seconds(false)
                                            ->default('17:00')
                                            ->required()
                                            ->columnSpanFull()
                                            ->visibleJs(<<<'JS'
                                                ! $get('is_closed')
                                                JS),
                                    ])
                                    ->visibleJs(<<<'JS'
                                        $get('status_mode') === 'automatic'
                                        JS),
                            ]),

                        Tab::make('LBP Pricing')
                            ->icon(Heroicon::OutlinedCurrencyDollar)
                            ->schema([
                                Toggle::make('show_lbp_prices')
                                    ->label('Enable LBP pricing')
                                    ->validationAttribute('enable LBP pricing')
                                    ->helperText('Turn on to allow prices to be displayed in Lebanese Pounds.')
                                    ->columnSpanFull()
                                    ->live()
                                    ->afterStateUpdated(function (bool $state, callable $set): void {
                                        // Fall back to USD-only when LBP pricing is turned off.
                                        if (! $state) {
                                            $set('price_display', PriceDisplay::USD->value);
                                        }
                                    }),

                                TextInput::make('lbp_exchange_rate')
                                    ->label('LBP exchange rate')
                                    ->validationAttribute('LBP exchange rate')
                                    ->helperText('Amount of LBP per 1 USD.')
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix('LBP')
                                    ->default(90000)
                                    ->columnSpanFull()
                                    ->live(onBlur: true)
                                    ->requiredIf('show_lbp_prices', true)
                                    ->visibleJs(<<<'JS'
                                        $get('show_lbp_prices')
                                        JS),
                            ]),

                        Tab::make('Price Display')
                            ->icon(Heroicon::OutlinedBanknotes)
                            ->schema([
                                Radio::make('price_display')
                                    ->label('Price display')
                                    ->options(PriceDisplay::class)
                                    ->default(PriceDisplay::USD->value)
                                    ->helperText('LBP and Both require LBP pricing to be enabled with a valid exchange rate.')
                                    ->columnSpanFull()
                                    ->disableOptionWhen(function (string $value, Get $get): bool {
                                        // Only USD is available unless LBP pricing is enabled with a rate.
                                        $lbpReady = $get('show_lbp_prices') && (float) $get('lbp_exchange_rate') > 0;

                                        return $value !== PriceDisplay::USD->value && ! $lbpReady;
                                    }),
                            ]),

                        Tab::make('WhatsApp Badge')
                            ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                            ->schema([
                                Toggle::make('show_whatsapp_badge')
                                    ->label('Show WhatsApp badge')
                                    ->helperText('Shows a floating WhatsApp button on the storefront for customers to message you.')
                                    ->default(false)
                                    ->columnSpanFull()
                                    ->live(),

                                TextInput::make('whatsapp_badge_number')
                                    ->label('WhatsApp number')
                                    ->validationAttribute('WhatsApp number')
                                    ->helperText('Messages from the badge are sent to this number. Include the country code.')
                                    ->tel()
                                    ->default('+96178792289')
                                    ->maxLength(255)
                                    ->requiredIf('show_whatsapp_badge', true)
                                    ->columnSpanFull()
                                    ->visibleJs(<<<'JS'
                                        $get('show_whatsapp_badge')
                                        JS),
                            ]),

                        Tab::make('Social')
                            ->icon(Heroicon::OutlinedShare)
                            ->schema([
                                Repeater::make('social_links')
                                    ->label('Social media links')
                                    ->helperText('These appear in the storefront footer.')
                                    ->addActionLabel('Add link')
                                    ->columnSpanFull()
                                    ->itemLabel(function (array $state): ?string {
                                        $platform = $state['platform'] ?? null;

                                        if (! $platform instanceof SocialPlatform) {
                                            $platform = is_string($platform) ? SocialPlatform::tryFrom($platform) : null;
                                        }

                                        if ($platform === SocialPlatform::OTHER) {
                                            return $state['name'] ?: $platform->getLabel();
                                        }

                                        return $platform?->getLabel();
                                    })
                                    ->schema([
                                        Select::make('platform')
                                            ->label('Platform')
                                            ->validationAttribute('platform')
                                            ->options(SocialPlatform::class)
                                            ->required()
                                            ->live()
                                            ->columnSpanFull(),

                                        TextInput::make('name')
                                            ->label('Name')
                                            ->validationAttribute('name')
                                            ->helperText('Shown as the link label on the storefront.')
                                            ->maxLength(255)
                                            ->requiredIf('platform', SocialPlatform::OTHER->value)
                                            ->columnSpanFull()
                                            ->visibleJs(<<<'JS'
                                                $get('platform') === 'other'
                                                JS),

                                        TextInput::make('url')
                                            ->label('Link')
                                            ->validationAttribute('link')
                                            ->url()
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}

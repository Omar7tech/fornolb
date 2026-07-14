<?php

use App\Enums\PriceDisplay;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.show_lbp_prices', false);
        $this->migrator->add('general.lbp_exchange_rate', 90000);
        $this->migrator->add('general.price_display', PriceDisplay::USD->value);
        $this->migrator->add('general.show_whatsapp_badge', false);
        $this->migrator->add('general.whatsapp_badge_number', '+96178792289');
    }
};

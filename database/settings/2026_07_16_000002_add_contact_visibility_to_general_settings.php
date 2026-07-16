<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.show_address', true);
        $this->migrator->add('general.address_map_url', null);
        $this->migrator->add('general.show_phone', true);
    }

    public function down(): void
    {
        $this->migrator->delete('general.show_phone');
        $this->migrator->delete('general.address_map_url');
        $this->migrator->delete('general.show_address');
    }
};

<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.phone_number', '+961 1 234 567');
    }

    public function down(): void
    {
        $this->migrator->delete('general.phone_number');
    }
};

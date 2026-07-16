<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Starts empty rather than with a sample: an invented number would be
        // published to the footer and the structured data as if it were real.
        $this->migrator->add('general.phone_number', null);
    }

    public function down(): void
    {
        $this->migrator->delete('general.phone_number');
    }
};

<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.organiser_name', 'Brazil Bangladesh Chamber of Commerce & Industry');
        $this->migrator->add('general.organiser_short_name', 'BBCCI');
        $this->migrator->add('general.office_address', 'Shanta Skymark, 18 Gulshan Avenue, Dhaka-1212, Bangladesh');
        $this->migrator->add('general.phone', '+880 1553 676767');
        $this->migrator->add('general.whatsapp_number', '8801553676767');
        $this->migrator->add('general.email', 'sg@brazilbangladeshchamber.com');
        $this->migrator->add('general.dpo_name', null);
        $this->migrator->add('general.dpo_email', null);
    }
};

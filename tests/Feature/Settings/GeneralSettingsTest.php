<?php

namespace Tests\Feature\Settings;

use App\Settings\GeneralSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneralSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ships_with_the_bbcci_contact_details(): void
    {
        $settings = app(GeneralSettings::class);

        $this->assertSame('Brazil Bangladesh Chamber of Commerce & Industry', $settings->organiser_name);
        $this->assertSame('BBCCI', $settings->organiser_short_name);
        $this->assertSame('Shanta Skymark, 18 Gulshan Avenue, Dhaka-1212, Bangladesh', $settings->office_address);
        $this->assertSame('+880 1553 676767', $settings->phone);
        $this->assertSame('8801553676767', $settings->whatsapp_number);
        $this->assertSame('sg@brazilbangladeshchamber.com', $settings->email);
        $this->assertNull($settings->dpo_name);
        $this->assertNull($settings->dpo_email);
    }
}

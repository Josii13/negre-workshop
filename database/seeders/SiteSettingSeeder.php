<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'contact_address',
                'value' => 'Cocody, Riviera Abatta<br>Abidjan, Côte d\'Ivoire',
                'type' => 'textarea',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_email',
                'value' => 'fredericnda.ci@gmail.com',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+225 07 68 29 89 65',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_hours',
                'value' => 'Lundi - Vendredi: 9h - 18h<br>Sur rendez-vous uniquement',
                'type' => 'textarea',
                'group' => 'contact',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '2250768298965',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'site_name',
                'value' => 'Frederic N\'DA',
                'type' => 'text',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}


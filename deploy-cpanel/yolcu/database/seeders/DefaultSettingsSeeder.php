<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Varsayılan ayarları uygula.
     */
    public function run(): void
    {
        if (Schema::hasTable('site_settings')) {
            $defaults = [
                'site_name' => ['value' => 'RADYOYOL', 'type' => 'text'],
                'site_slogan' => ['value' => '', 'type' => 'text'],
                'contact_email' => ['value' => '', 'type' => 'text'],
                'contact_phone' => ['value' => '', 'type' => 'text'],
                'address_text' => ['value' => '', 'type' => 'text'],
                'maintenance_mode' => ['value' => '0', 'type' => 'boolean'],
                'footer_legal_text' => ['value' => 'Radyoyol Tüm Hakları Saklıdır', 'type' => 'text'],
                'footer_legal_links_json' => ['value' => '[{"label":"Gizlilik Politikası","url":"/gizlilik"},{"label":"Çerez Politikası","url":"/cerez"},{"label":"Kullanım Şartları","url":"/kullanim"},{"label":"KVKK Aydınlatma Metni","url":"/kvkk"}]', 'type' => 'json'],
            ];

            foreach ($defaults as $key => $data) {
                if (!DB::table('site_settings')->where('key', $key)->exists()) {
                    DB::table('site_settings')->insert([
                        'key' => $key,
                        'value' => $data['value'],
                        'type' => $data['type'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        if (Schema::hasTable('site_theme') && !DB::table('site_theme')->exists()) {
            DB::table('site_theme')->insert([
                'theme_id' => 1,
                'bg_mode' => 'color',
                'bg_color' => '#0b0f16',
                'overlay_color' => '#000000',
                'overlay_opacity' => 55,
                'bg_blur' => 0,
                'button_color' => '#c92a2a',
                'button_hover_color' => '#dc2626',
                'schedule_color' => '#1e2430',
                'schedule_active_color' => '#c92a2a',
                'line_color' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

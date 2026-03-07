<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['mail_mailer', 'smtp', 'text'],
            ['mail_host', '', 'text'],
            ['mail_port', '587', 'text'],
            ['mail_username', '', 'text'],
            ['mail_password', '', 'text'],
            ['mail_encryption', 'tls', 'text'],
            ['mail_from_address', '', 'text'],
            ['mail_from_name', '', 'text'],
            ['mail_contact_to', '', 'text'],
        ];

        foreach ($settings as $s) {
            if (!DB::table('site_settings')->where('key', $s[0])->exists()) {
                DB::table('site_settings')->insert([
                    'key' => $s[0],
                    'value' => $s[1],
                    'type' => $s[2],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('site_settings')->whereIn('key', [
            'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password',
            'mail_encryption', 'mail_from_address', 'mail_from_name', 'mail_contact_to',
        ])->delete();
    }
};

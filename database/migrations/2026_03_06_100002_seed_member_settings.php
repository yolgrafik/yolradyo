<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['member_approval_required', '1', 'boolean'],
            ['member_daily_submission_limit', '5', 'integer'],
            ['member_max_mp3_size_mb', '20', 'integer'],
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
            'member_approval_required',
            'member_daily_submission_limit',
            'member_max_mp3_size_mb',
        ])->delete();
    }
};

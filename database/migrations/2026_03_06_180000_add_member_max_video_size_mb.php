<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!DB::table('site_settings')->where('key', 'member_max_video_size_mb')->exists()) {
            DB::table('site_settings')->insert([
                'key' => 'member_max_video_size_mb',
                'value' => '500',
                'type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'member_max_video_size_mb')->delete();
    }
};

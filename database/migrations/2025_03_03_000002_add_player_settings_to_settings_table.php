<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('radio_auto_play')->default(false)->after('radio_backup_stream_url');
            $table->decimal('radio_default_volume', 3, 2)->default(0.8)->after('radio_auto_play');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['radio_auto_play', 'radio_default_volume']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('shoutcast_base_url', 500)->nullable()->after('radio_default_volume');
            $table->unsignedTinyInteger('shoutcast_sid')->default(1)->after('shoutcast_base_url');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['shoutcast_base_url', 'shoutcast_sid']);
        });
    }
};

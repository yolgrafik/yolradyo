<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('video_type', 20)->nullable()->after('description');
            $table->string('video_youtube_url', 500)->nullable()->after('video_type');
            $table->string('video_path', 500)->nullable()->after('video_youtube_url');
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn(['video_type', 'video_youtube_url', 'video_path']);
        });
    }
};

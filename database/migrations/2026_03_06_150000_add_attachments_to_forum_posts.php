<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->string('video_url', 500)->nullable()->after('body');
            $table->string('file_path')->nullable()->after('video_url');
            $table->string('file_name')->nullable()->after('file_path');
            $table->string('file_type', 20)->nullable()->after('file_name'); // mp3, photo
        });
    }

    public function down(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'file_path', 'file_name', 'file_type']);
        });
    }
};

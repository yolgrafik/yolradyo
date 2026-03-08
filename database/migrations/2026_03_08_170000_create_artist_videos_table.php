<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_description', 500)->nullable();
            $table->string('cover_image_path')->nullable();
            $table->enum('video_type', ['mp4', 'youtube'])->default('youtube');
            $table->string('mp4_path')->nullable();
            $table->string('youtube_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_videos');
    }
};

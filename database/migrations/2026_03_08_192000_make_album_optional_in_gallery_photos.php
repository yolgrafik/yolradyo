<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
        });

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->unsignedBigInteger('album_id')->nullable()->change();
            $table->foreign('album_id')->references('id')->on('photo_albums')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
        });

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->unsignedBigInteger('album_id')->nullable(false)->change();
            $table->foreign('album_id')->references('id')->on('photo_albums')->cascadeOnDelete();
        });
    }
};

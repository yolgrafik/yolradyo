<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programcilar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('slug')->unique();
            $table->string('avatar_path')->nullable();
            $table->string('kisa_aciklama')->nullable();
            $table->longText('uzun_aciklama')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();
            $table->string('website')->nullable();
            $table->boolean('aktif')->default(true);
            $table->unsignedInteger('sira')->default(0);
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('programcilar', function (Blueprint $table) {
            $table->index('slug');
            $table->index('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programcilar');
    }
};

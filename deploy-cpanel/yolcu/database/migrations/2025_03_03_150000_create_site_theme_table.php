<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_theme')) {
            return;
        }

        Schema::create('site_theme', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('theme_id')->default(1);
            $table->enum('bg_mode', ['color', 'image'])->default('color');
            $table->string('bg_color', 16)->default('#0b0f16');
            $table->string('bg_image', 255)->nullable();
            $table->string('overlay_color', 16)->default('#000000');
            $table->unsignedTinyInteger('overlay_opacity')->default(55);
            $table->unsignedTinyInteger('bg_blur')->default(0);
            $table->timestamps();
        });

        DB::table('site_theme')->insert([
            'theme_id' => 1,
            'bg_mode' => 'color',
            'bg_color' => '#0b0f16',
            'overlay_color' => '#000000',
            'overlay_opacity' => 55,
            'bg_blur' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_theme');
    }
};

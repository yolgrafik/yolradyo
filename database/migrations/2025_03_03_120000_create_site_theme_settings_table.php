<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_theme_settings', function (Blueprint $table) {
            $table->id();
            $table->string('primary', 20)->default('#ff0033');
            $table->string('primary_hover', 20)->default('#ff3355');
            $table->string('secondary', 20)->default('#374151');
            $table->string('secondary_hover', 20)->default('#4b5563');
            $table->string('accent', 20)->default('#c92a2a');
            $table->string('glow', 20)->default('#c92a2a');
            $table->string('background', 20)->default('#0b0f16');
            $table->string('surface', 20)->default('#111827');
            $table->string('surface_2', 20)->default('#0f172a');
            $table->string('border', 30)->default('rgba(255,255,255,0.12)');
            $table->string('text', 20)->default('#ffffff');
            $table->string('text_muted', 20)->default('#a9b1c3');
            $table->string('link', 20)->default('#60a5fa');
            $table->string('link_hover', 20)->default('#93c5fd');
            $table->string('header_bg', 50)->nullable();
            $table->string('header_text', 20)->default('#ffffff');
            $table->string('header_active', 20)->default('#c92a2a');
            $table->string('footer_bg', 50)->nullable();
            $table->string('footer_text', 30)->default('#a9b1c3');
            $table->string('footer_link', 30)->default('#a9b1c3');
            $table->string('footer_link_hover', 20)->default('#ffffff');
            $table->string('input_bg', 30)->default('rgba(255,255,255,0.06)');
            $table->string('input_text', 20)->default('#f0f2f5');
            $table->string('focus_ring', 20)->default('#c92a2a');
            $table->unsignedSmallInteger('radius')->default(14);
            $table->timestamps();
        });

        DB::table('site_theme_settings')->insert([
            'primary' => '#ff0033',
            'primary_hover' => '#ff3355',
            'secondary' => '#374151',
            'secondary_hover' => '#4b5563',
            'accent' => '#c92a2a',
            'glow' => '#c92a2a',
            'background' => '#0b0f16',
            'surface' => '#111827',
            'surface_2' => '#0f172a',
            'border' => 'rgba(255,255,255,0.12)',
            'text' => '#ffffff',
            'text_muted' => '#a9b1c3',
            'link' => '#60a5fa',
            'link_hover' => '#93c5fd',
            'header_text' => '#ffffff',
            'header_active' => '#c92a2a',
            'footer_text' => '#a9b1c3',
            'footer_link' => '#a9b1c3',
            'footer_link_hover' => '#ffffff',
            'input_bg' => 'rgba(255,255,255,0.06)',
            'input_text' => '#f0f2f5',
            'focus_ring' => '#c92a2a',
            'radius' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_theme_settings');
    }
};

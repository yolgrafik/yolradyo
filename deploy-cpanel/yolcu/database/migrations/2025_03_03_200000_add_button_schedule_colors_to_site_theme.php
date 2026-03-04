<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('site_theme')) {
            return;
        }

        Schema::table('site_theme', function (Blueprint $table) {
            if (!Schema::hasColumn('site_theme', 'button_color')) {
                $table->string('button_color', 16)->default('#c92a2a')->after('bg_blur');
            }
            if (!Schema::hasColumn('site_theme', 'button_hover_color')) {
                $table->string('button_hover_color', 16)->default('#dc2626')->after('button_color');
            }
            if (!Schema::hasColumn('site_theme', 'schedule_color')) {
                $table->string('schedule_color', 16)->default('#1e2430')->after('button_hover_color');
            }
            if (!Schema::hasColumn('site_theme', 'schedule_active_color')) {
                $table->string('schedule_active_color', 16)->default('#c92a2a')->after('schedule_color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_theme', function (Blueprint $table) {
            $table->dropColumn(['button_color', 'button_hover_color', 'schedule_color', 'schedule_active_color']);
        });
    }
};

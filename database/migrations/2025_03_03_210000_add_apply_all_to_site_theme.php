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
            if (!Schema::hasColumn('site_theme', 'apply_all')) {
                $table->boolean('apply_all')->default(false)->after('schedule_active_color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_theme', function (Blueprint $table) {
            $table->dropColumn('apply_all');
        });
    }
};

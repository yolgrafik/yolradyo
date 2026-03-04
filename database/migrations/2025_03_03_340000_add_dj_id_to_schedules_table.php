<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('dj_id')->nullable()->after('host');
            $table->foreign('dj_id')->references('id')->on('dj_profiles')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['dj_id']);
            $table->dropColumn('dj_id');
        });
    }
};

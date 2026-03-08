<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            if (!Schema::hasColumn('sponsors', 'video_poster_path')) {
                $table->string('video_poster_path', 500)->nullable()->after('video_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('video_poster_path');
        });
    }
};

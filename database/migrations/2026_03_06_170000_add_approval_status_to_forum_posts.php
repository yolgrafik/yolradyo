<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->string('approval_status', 20)->default('pending')->after('status');
        });

        DB::table('forum_posts')
            ->whereIn('type', ['request', 'complaint', 'mp3'])
            ->update(['approval_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};

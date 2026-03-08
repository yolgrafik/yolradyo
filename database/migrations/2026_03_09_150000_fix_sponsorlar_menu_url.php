<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('menu_items')) {
            return;
        }

        DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->where('title', 'Sponsorlar')
            ->where('url', '/reklam')
            ->update(['url' => '/sponsorlar']);
    }

    public function down(): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('menu_items')) {
            return;
        }

        DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->where('title', 'Sponsorlar')
            ->where('url', '/sponsorlar')
            ->update(['url' => '/reklam']);
    }
};

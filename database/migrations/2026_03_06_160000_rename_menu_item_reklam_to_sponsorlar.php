<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('menu_items')) {
            return;
        }

        DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->where(function ($q) {
                $q->where('url', '/reklam')
                    ->orWhereIn('title', ['Reklam & Isbirligi', 'Reklam & İşbirliği', 'Sponsor']);
            })
            ->update(['title' => 'Sponsorlar']);
    }

    public function down(): void
    {
        if (!Schema::hasTable('menu_items')) {
            return;
        }

        DB::table('menu_items')
            ->where('location', 'header')
            ->whereNull('parent_id')
            ->where('title', 'Sponsorlar')
            ->update(['title' => 'Reklam & Isbirligi']);
    }
};

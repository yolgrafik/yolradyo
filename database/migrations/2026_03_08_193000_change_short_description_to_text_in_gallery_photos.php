<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('gallery_photos') && Schema::hasColumn('gallery_photos', 'short_description')) {
            DB::statement('ALTER TABLE gallery_photos MODIFY short_description TEXT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('gallery_photos') && Schema::hasColumn('gallery_photos', 'short_description')) {
            DB::statement('ALTER TABLE gallery_photos MODIFY short_description VARCHAR(500) NULL');
        }
    }
};

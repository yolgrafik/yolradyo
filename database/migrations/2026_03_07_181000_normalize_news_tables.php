<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $table = null;
        foreach (['news', 'news_posts', 'haberler'] as $candidate) {
            if (Schema::hasTable($candidate)) {
                $table = $candidate;
                break;
            }
        }

        if ($table === null) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('excerpt', 500)->nullable();
                $table->text('content')->nullable();
                $table->string('image')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($table) {
            if (!Schema::hasColumn($table, 'title')) {
                $blueprint->string('title')->nullable();
            }
            if (!Schema::hasColumn($table, 'excerpt')) {
                $blueprint->string('excerpt', 500)->nullable();
            }
            if (!Schema::hasColumn($table, 'content')) {
                $blueprint->text('content')->nullable();
            }
            if (!Schema::hasColumn($table, 'image')) {
                $blueprint->string('image')->nullable();
            }
            if (!Schema::hasColumn($table, 'status')) {
                $blueprint->boolean('status')->default(true);
            }
            if (!Schema::hasColumn($table, 'created_at') && !Schema::hasColumn($table, 'updated_at')) {
                $blueprint->timestamps();
            }
        });

        if (Schema::hasColumn($table, 'image_path') && Schema::hasColumn($table, 'image')) {
            DB::table($table)->whereNull('image')->update([
                'image' => DB::raw('image_path'),
            ]);
        }
    }

    public function down(): void
    {
        // Intentionally no destructive rollback for normalized table structures.
    }
};

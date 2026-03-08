<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
                $table->string('slug')->unique();
                $table->string('excerpt', 500)->nullable();
                $table->text('content')->nullable();
                $table->string('cover_image')->nullable();
                $table->string('video_url')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
            $table = 'news';
        } else {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                if (!Schema::hasColumn($table, 'slug')) {
                    $blueprint->string('slug')->nullable()->after('title');
                }
                if (!Schema::hasColumn($table, 'cover_image')) {
                    $blueprint->string('cover_image')->nullable();
                }
                if (!Schema::hasColumn($table, 'video_url')) {
                    $blueprint->string('video_url')->nullable();
                }
            });
        }

        if (Schema::hasColumn($table, 'image') && Schema::hasColumn($table, 'cover_image')) {
            DB::table($table)->whereNull('cover_image')->update([
                'cover_image' => DB::raw('image'),
            ]);
        } elseif (Schema::hasColumn($table, 'image_path') && Schema::hasColumn($table, 'cover_image')) {
            DB::table($table)->whereNull('cover_image')->update([
                'cover_image' => DB::raw('image_path'),
            ]);
        }

        $items = DB::table($table)->select('id', 'title', 'slug')->get();
        foreach ($items as $item) {
            $base = Str::slug((string) ($item->title ?: 'haber-' . $item->id));
            if ($base === '') {
                $base = 'haber-' . $item->id;
            }
            $slug = $base;
            $i = 2;
            while (DB::table($table)->where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                $slug = $base . '-' . $i;
                $i++;
            }
            if ($item->slug !== $slug) {
                DB::table($table)->where('id', $item->id)->update(['slug' => $slug]);
            }
        }

        if (Schema::hasColumn($table, 'slug')) {
            try {
                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    $blueprint->unique('slug', $table . '_slug_unique');
                });
            } catch (\Throwable $e) {
                // Unique already exists or unsupported by existing state.
            }
        }

        if (!Schema::hasTable('news_media')) {
            Schema::create('news_media', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('news_id');
                $table->string('type', 20);
                $table->string('file_path');
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
                $table->index(['news_id', 'sort_order']);
                $table->index('type');
            });
        }
    }

    public function down(): void
    {
        // Non-destructive rollback intentionally.
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->after('title');
            $table->text('description')->nullable()->after('short_description');
        });

        $rows = \DB::table('sponsors')->get();
        foreach ($rows as $row) {
            $slug = Str::slug($row->title) . '-' . Str::random(4);
            \DB::table('sponsors')->where('id', $row->id)->update(['slug' => $slug]);
        }

        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('slug', 255)->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description']);
        });
    }
};

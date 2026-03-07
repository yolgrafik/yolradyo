<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('news') || Schema::hasTable('news_posts') || Schema::hasTable('haberler')) {
            return;
        }

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('excerpt', 500)->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

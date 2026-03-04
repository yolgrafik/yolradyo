<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dj_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bio')->nullable();
            $table->string('initials', 10)->nullable();
            $table->string('avatar_path')->nullable();
            $table->boolean('is_live')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dj_profiles');
    }
};

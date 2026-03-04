<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_two_factor', function (Blueprint $table) {
            $table->foreignId('admin_id')->primary()->constrained('admins')->cascadeOnDelete();
            $table->boolean('enabled')->default(false);
            $table->text('secret')->nullable();
            $table->json('recovery_codes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_two_factor');
    }
};

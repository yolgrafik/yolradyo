<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('radio_stream_url')->nullable();
            $table->string('radio_backup_stream_url')->nullable();
            $table->timestamps();
        });

        \DB::table('settings')->insert([
            'radio_stream_url' => null,
            'radio_backup_stream_url' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

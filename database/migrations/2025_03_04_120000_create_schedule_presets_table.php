<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_presets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $defaults = [
            ['title' => 'Sabah Kuşağı', 'start_time' => '06:00', 'end_time' => '10:00', 'sort_order' => 1],
            ['title' => 'Öğle Yayını', 'start_time' => '12:00', 'end_time' => '15:00', 'sort_order' => 2],
            ['title' => 'Öğleden Sonra', 'start_time' => '15:00', 'end_time' => '18:00', 'sort_order' => 3],
            ['title' => 'Akşam Kuşağı', 'start_time' => '18:00', 'end_time' => '22:00', 'sort_order' => 4],
        ];
        foreach ($defaults as $d) {
            DB::table('schedule_presets')->insert(array_merge($d, ['created_at' => now(), 'updated_at' => now()]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_presets');
    }
};

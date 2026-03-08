<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('about_pages')) {
            return;
        }

        $now = now();
        DB::table('about_pages')->updateOrInsert(
            ['slug' => 'reklam'],
            [
                'title' => 'Reklam',
                'short_description' => 'Markanizi RadyoYol yayinlari ve dijital platformlariyla hedef kitlenize etkili bicimde ulastirin.',
                'content' => '<p>RadyoYol, markalar icin guvenilir ve etkili bir tanitim ortami sunar. Spot yayinlar, program sponsorlugu ve dijital gorunurluk secenekleri ile kurumunuza uygun reklam cozumleri planliyoruz.</p><p>Reklam sureclerinde sektore uygun dil, hedef kitle analizi ve performans odakli planlama ile ilerliyoruz. Is birligi talepleriniz icin iletisim sayfamizdan bizimle iletisime gecebilirsiniz.</p>',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    public function down(): void
    {
        if (!Schema::hasTable('about_pages')) {
            return;
        }

        DB::table('about_pages')->where('slug', 'reklam')->delete();
    }
};

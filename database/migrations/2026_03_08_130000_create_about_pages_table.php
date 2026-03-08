<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('about_pages')) {
            Schema::create('about_pages', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('title');
                $table->string('short_description', 500)->nullable();
                $table->longText('content')->nullable();
                $table->string('image_path')->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }

        $now = now();
        $defaults = [
            [
                'slug' => 'biz-kimiz',
                'title' => 'Biz Kimiz',
                'short_description' => 'RadyoYol, yerel kulturu modern yayin anlayisiyla bulusturan bagimsiz bir radyo platformudur.',
                'content' => '<p>RadyoYol; muzik, kultur ve toplumsal hafizayi bir araya getiren yayin anlayisiyla kurulmustur. Dinleyiciyle ayni frekansta kalmayi hedefleyen ekibimiz, gelenekten beslenen ancak dijital dunyanin hizina uyum saglayan bir icerik modeliyle calisir.</p><p>Yayin planlamasindan program iceriklerine kadar her adimda kalite, sureklilik ve guven ilkelerini merkeze aliyoruz. Yerel degerleri korurken yeni nesil dinleme aliskanliklarina uygun bir deneyim sunmayi onceliklendiriyoruz.</p>',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'misyon',
                'title' => 'Misyon & Vizyon',
                'short_description' => 'Misyonumuz nitelikli icerik uretmek, vizyonumuz ise bolgesel sesi ulusal dijital bir markaya donusturmektir.',
                'content' => '<h2>Misyonumuz</h2><p>Dinleyicilerimize guvenilir, kaliteli ve surekli yayin deneyimi sunarken kulturel mirasa sahip cikan programlar uretmek temel misyonumuzdur.</p><h2>Vizyonumuz</h2><p>RadyoYol markasini yerel koklerinden guc alarak ulusal ve uluslararasi dijital platformlarda taninan bir yayin merkezi haline getirmek hedefimizdir.</p>',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'politika',
                'title' => 'Yayin Politikamiz',
                'short_description' => 'Yayin politikamiz etik ilkelere, toplumsal sorumluluga ve tarafsiz bilgi aktarimina dayanir.',
                'content' => '<p>RadyoYol yayin politikasinda tarafsizlik, saygi ve toplumsal sorumluluk esas alinir. Iceriklerimizde ayrimciliga, nefret soylemine ve yaniltici bilgiye yer verilmez.</p><p>Program icerikleri editoryal denetim surecinden gecirilir; dinleyici geri bildirimleri duzenli olarak degerlendirilir. Reklam, sponsorluk ve is birliklerinde seffaflik ilkesi korunur.</p>',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($defaults as $item) {
            DB::table('about_pages')->updateOrInsert(
                ['slug' => $item['slug']],
                array_merge($item, ['created_at' => $now, 'updated_at' => $now])
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuickNewsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $items = [
            [
                'title' => 'RadyoYol Yeni Sitesi Yayinda: Daha Hizli ve Modern Deneyim',
                'slug' => 'radyoyol-yeni-sitesi-yayinda-daha-hizli-ve-modern-deneyim',
                'excerpt' => 'RadyoYol yenilenen arayuzu ve performans iyilestirmeleriyle yayinda.',
                'content' => 'RadyoYol yeni web sitesi; daha hizli sayfa gecisleri, mobil uyumluluk ve gelistirilmis canli yayin deneyimi ile kullanicilarla bulustu. Yeni altyapi sayesinde icerikler daha stabil ve daha hizli yukleniyor.',
                'status' => 1,
            ],
            [
                'title' => 'Yeni Haberler Alani Ile Guncel Icerikler Tek Noktada',
                'slug' => 'yeni-haberler-alani-ile-guncel-icerikler-tek-noktada',
                'excerpt' => 'Haberler bolumuyle RadyoYol duyurulari artik daha duzenli.',
                'content' => 'Siteye eklenen Haberler alani sayesinde yayin, program ve platform duyurulari tek bir merkezde toplandi. Kullanicilar en yeni gelismelere anasayfadan kolayca ulasabiliyor.',
                'status' => 1,
            ],
            [
                'title' => 'Gelismis Mobil Uyum: RadyoYol Her Ekranda Hazir',
                'slug' => 'gelismis-mobil-uyum-radyoyol-her-ekranda-hazir',
                'excerpt' => 'Yeni tasarim telefon ve tabletlerde daha akici kullanim sunuyor.',
                'content' => 'RadyoYol yeni temasi mobil cihazlar icin optimize edildi. Menu, oynatici ve icerik bloklari farkli ekran boyutlarinda daha okunabilir ve daha kullanisli hale getirildi.',
                'status' => 1,
            ],
            [
                'title' => 'Canli Yayin ve Program Akisi Bilesenleri Yenilendi',
                'slug' => 'canli-yayin-ve-program-akisi-bilesenleri-yenilendi',
                'excerpt' => 'Program akis kartlari ve canli yayin gostergeleri guclendirildi.',
                'content' => 'Yeni surumle birlikte canli yayin alani, program akis gosterimi ve ilgili bilesenler guncellendi. Dinleyiciler artik yayindaki icerikleri daha net ve anlik takip edebiliyor.',
                'status' => 1,
            ],
            [
                'title' => 'RadyoYol Altyapisi Guncellendi: Daha Guvenli ve Kararli',
                'slug' => 'radyoyol-altyapisi-guncellendi-daha-guvenli-ve-kararli',
                'excerpt' => 'Arka plan iyilestirmeleriyle kesintisiz deneyim hedefleniyor.',
                'content' => 'Veritabani ve uygulama altyapisinda yapilan teknik iyilestirmelerle RadyoYol daha guvenli ve daha kararli bir yapiya kavustu. Bu guncellemeler site surekliligi ve performansa dogrudan katki sagliyor.',
                'status' => 1,
            ],
        ];

        foreach ($items as $item) {
            DB::table('news')->updateOrInsert(
                ['slug' => $item['slug']],
                array_merge($item, ['created_at' => $now, 'updated_at' => $now])
            );
        }
    }
}

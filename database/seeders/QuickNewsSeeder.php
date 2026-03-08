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
                'title' => 'RadyoYol Yeni Sitesi Yayında: Daha Hızlı ve Modern Deneyim',
                'slug' => 'radyoyol-yeni-sitesi-yayinda-daha-hizli-ve-modern-deneyim',
                'excerpt' => 'RadyoYol yenilenen arayüzü ve performans iyileştirmeleriyle yayında.',
                'content' => 'RadyoYol yeni web sitesi; daha hızlı sayfa geçişleri, mobil uyumluluk ve geliştirilmiş canlı yayın deneyimi ile kullanıcılarla buluştu. Yeni altyapı sayesinde içerikler daha stabil ve daha hızlı yükleniyor.',
                'status' => 1,
            ],
            [
                'title' => 'Yeni Haberler Alanı ile Güncel İçerikler Tek Noktada',
                'slug' => 'yeni-haberler-alani-ile-guncel-icerikler-tek-noktada',
                'excerpt' => 'Haberler bölümüyle RadyoYol duyuruları artık daha düzenli.',
                'content' => 'Siteye eklenen Haberler alanı sayesinde yayın, program ve platform duyuruları tek bir merkezde toplandı. Kullanıcılar en yeni gelişmelere anasayfadan kolayca ulaşabiliyor.',
                'status' => 1,
            ],
            [
                'title' => 'Gelişmiş Mobil Uyum: RadyoYol Her Ekranda Hazır',
                'slug' => 'gelismis-mobil-uyum-radyoyol-her-ekranda-hazir',
                'excerpt' => 'Yeni tasarım telefon ve tabletlerde daha akıcı kullanım sunuyor.',
                'content' => 'RadyoYol yeni teması mobil cihazlar için optimize edildi. Menü, oynatıcı ve içerik blokları farklı ekran boyutlarında daha okunabilir ve daha kullanışlı hale getirildi.',
                'status' => 1,
            ],
            [
                'title' => 'Canlı Yayın ve Program Akışı Bileşenleri Yenilendi',
                'slug' => 'canli-yayin-ve-program-akisi-bilesenleri-yenilendi',
                'excerpt' => 'Program akış kartları ve canlı yayın göstergeleri güçlendirildi.',
                'content' => 'Yeni sürümle birlikte canlı yayın alanı, program akışı gösterimi ve ilgili bileşenler güncellendi. Dinleyiciler artık yayındaki içerikleri daha net ve anlık takip edebiliyor.',
                'status' => 1,
            ],
            [
                'title' => 'RadyoYol Altyapısı Güncellendi: Daha Güvenli ve Kararlı',
                'slug' => 'radyoyol-altyapisi-guncellendi-daha-guvenli-ve-kararli',
                'excerpt' => 'Arka plan iyileştirmeleriyle kesintisiz deneyim hedefleniyor.',
                'content' => 'Veritabanı ve uygulama altyapısında yapılan teknik iyileştirmelerle RadyoYol daha güvenli ve daha kararlı bir yapıya kavuştu. Bu güncellemeler site sürekliliği ve performansa doğrudan katkı sağlıyor.',
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

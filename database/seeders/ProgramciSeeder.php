<?php

namespace Database\Seeders;

use App\Models\Programci;
use Illuminate\Database\Seeder;

class ProgramciSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'ad' => 'Fido',
                'slug' => 'fido',
                'kisa_aciklama' => 'Heybemdeki Türküler',
                'uzun_aciklama' => "Fido, yıllardır radyomuzda Türk halk müziğinin en güzel örneklerini dinleyicilerle buluşturuyor. Heybemdeki Türküler programı ile Anadolu'nun dört bir yanından türküleri sizlere ulaştırıyor.",
                'email' => 'fido@radyoyol.com',
                'instagram' => 'https://instagram.com/fido',
                'facebook' => 'https://facebook.com/fido',
                'youtube' => 'https://youtube.com/@fido',
                'aktif' => true,
                'sira' => 1,
            ],
            [
                'ad' => 'Markaz',
                'slug' => 'markaz',
                'kisa_aciklama' => 'Gurbetten SİLAYA',
                'uzun_aciklama' => "Markaz, gurbetçi dinleyicilerimiz için özel hazırladığı Gurbetten SİLAYA programı ile memleket hasretini gideriyor. Her hafta en sevilen türküler ve anılar sizlerle.",
                'email' => 'markaz@radyoyol.com',
                'instagram' => 'https://instagram.com/markaz',
                'facebook' => 'https://facebook.com/markaz',
                'youtube' => 'https://youtube.com/@markaz',
                'aktif' => true,
                'sira' => 2,
            ],
            [
                'ad' => 'Ozocan',
                'slug' => 'ozocan',
                'kisa_aciklama' => 'Yol Türküleri',
                'uzun_aciklama' => "Ozocan ile Yol Türküleri programında, yollara düşenlerin türkülerini dinliyoruz. Uzun yollar, güzel anılar ve unutulmaz melodiler.",
                'email' => 'ozocan@radyoyol.com',
                'instagram' => 'https://instagram.com/ozocan',
                'facebook' => 'https://facebook.com/ozocan',
                'tiktok' => 'https://tiktok.com/@ozocan',
                'youtube' => 'https://youtube.com/@ozocan',
                'aktif' => true,
                'sira' => 3,
            ],
        ];

        foreach ($items as $item) {
            Programci::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
